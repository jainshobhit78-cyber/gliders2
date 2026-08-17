<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FinanceReturn;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FinanceReturnController extends Controller
{
    public function list()
    {
        $items = FinanceReturn::orderBy('display_order')->orderByDesc('fiscal_year')->get();

        return view('backend.finance.returns.list', compact('items'));
    }

    public function add()
    {
        return view('backend.finance.returns.add');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $year = $this->normaliseYear($data['fiscal_year']);
        $request->merge(['fiscal_year' => $year]);
        $request->validate(['fiscal_year' => Rule::unique('finance_returns', 'fiscal_year')]);

        $item = FinanceReturn::create([
            'fiscal_year' => $year,
            'display_order' => (FinanceReturn::max('display_order') ?? 0) + 1,
        ]);

        if ($request->hasFile('pdf')) {
            $item->update(['pdf' => $this->storePdf($request->file('pdf'), $year)]);
        }

        return redirect('admin/finance?tab=returns')->with('success', 'Annual return added successfully.');
    }

    public function edit($id)
    {
        $item = FinanceReturn::findOrFail($id);

        return view('backend.finance.returns.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = FinanceReturn::findOrFail($id);
        $data = $this->validated($request);
        $year = $this->normaliseYear($data['fiscal_year']);
        $request->merge(['fiscal_year' => $year]);
        $request->validate(['fiscal_year' => Rule::unique('finance_returns', 'fiscal_year')->ignore($item->id)]);

        if ($request->hasFile('pdf')) {
            $this->deletePdf($item->pdf);
            $item->pdf = $this->storePdf($request->file('pdf'), $year);
        } elseif ($item->pdf && $item->fiscal_year !== $year) {
            $oldPath = public_path('uploads/finance/'.$item->pdf);
            $newName = 'Annual Return Year '.$year.'.pdf';
            $newPath = public_path('uploads/finance/'.$newName);

            if (is_file($oldPath)) {
                if (is_file($newPath)) {
                    unlink($newPath);
                }
                rename($oldPath, $newPath);
                $item->pdf = $newName;
            }
        }

        $item->fiscal_year = $year;
        $item->save();

        return redirect('admin/finance?tab=returns')->with('success', 'Annual return updated successfully.');
    }

    public function delete($id)
    {
        $item = FinanceReturn::findOrFail($id);
        $this->deletePdf($item->pdf);
        $item->delete();

        return redirect('admin/finance?tab=returns')->with('success', 'Annual return deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'fiscal_year' => ['required', 'regex:/^(?:20)?\d{2}-\d{2}$/'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
        ]);
    }

    private function normaliseYear(string $year): string
    {
        return preg_replace('/^20(?=\d{2}-)/', '', trim($year));
    }

    private function storePdf($file, string $year): string
    {
        $directory = public_path('uploads/finance');
        $name = 'Annual Return Year '.$year.'.pdf';

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (is_file($directory.DIRECTORY_SEPARATOR.$name)) {
            unlink($directory.DIRECTORY_SEPARATOR.$name);
        }

        $file->move($directory, $name);

        return $name;
    }

    private function deletePdf(?string $pdf): void
    {
        if (! $pdf) {
            return;
        }

        $path = public_path('uploads/finance/'.$pdf);
        if (is_file($path)) {
            unlink($path);
        }
    }
}
