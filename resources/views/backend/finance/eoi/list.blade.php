<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">

            EOI for Banks

        </h5>

        @if(auth()->guard('admin')->user()->can('eoi_for_banks.create'))
            <a href="javascript:void(0)" class="btn btn-theme openEoiAdd" data-url="{{ url('admin/finance/eoi/add') }}">

                Add New EOI

            </a>
        @endif
    </div>


    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                @include('_message')

                <div class="table-responsive">

                    <table class="user-table table table-striped">

                        <thead>

                            <tr>
                                <th style="width: 50px;"></th>
                                <th style="width: 100px; text-align: center;">Order</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody id="eoiTbody">

                            @forelse($items as $key => $item)

                                <tr draggable="true" data-id="{{$item->id}}" class="draggable-row">

                                    <td style="vertical-align: middle; text-align: center; cursor: move;">
                                        <span class="drag-handle" style="font-size: 18px; color: #888;">☰</span>
                                    </td>

                                    <td style="vertical-align: middle; text-align: center;">
                                        <input type="number" class="form-control form-control-sm display-order-input text-center" 
                                               data-id="{{$item->id}}" value="{{$item->display_order}}" 
                                               style="width: 70px; margin: 0 auto; border-radius: 4px;">
                                    </td>

                                    <td style="vertical-align: middle;">{{$item->title}}</td>

                                    <td style="vertical-align: middle;">{{ \Str::limit(strip_tags($item->description), 120) }}</td>

                                    <td style="vertical-align: middle;">

                                        @if($item->pdf)

                                            <a href="{{asset('uploads/finance/' . $item->pdf)}}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td style="vertical-align: middle;">

                                        <ul class="table-action" style="margin-bottom: 0;">
                                            @if(auth()->guard('admin')->user()->can('eoi_for_banks.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openEoiEdit"
                                                        data-url="{{ url('admin/finance/eoi/edit/' . $item->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('eoi_for_banks.delete'))
                                                <li>

                                                    <x-delete-form :action="url('admin/finance/eoi/delete/' . $item->id)" class="btn btn-delete" confirm="Delete this record?" />

                                                </li>
                                            @endif

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center">No Data Found</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    (function() {
        let dragRow = null;
        const tbody = document.querySelector('#eoiTbody');

        if (tbody) {
            tbody.querySelectorAll('tr.draggable-row').forEach(function(row) {
                row.addEventListener('dragstart', function(e) {
                    dragRow = row;
                    row.style.opacity = '0.4';
                    e.dataTransfer.effectAllowed = 'move';
                });
                row.addEventListener('dragend', function() {
                    row.style.opacity = '1';
                });
                row.addEventListener('dragover', function(e) {
                    e.preventDefault();
                });
                row.addEventListener('drop', function(e) {
                    e.preventDefault();
                    if (!dragRow || dragRow === row) return;

                    let parent = row.parentNode;
                    let rows = Array.from(parent.querySelectorAll('tr.draggable-row'));
                    let fromIndex = rows.indexOf(dragRow);
                    let toIndex = rows.indexOf(row);

                    if (fromIndex < toIndex) {
                        parent.insertBefore(dragRow, row.nextSibling);
                    } else {
                        parent.insertBefore(dragRow, row);
                    }

                    // Update input values on screen dynamically
                    let updatedRows = Array.from(parent.querySelectorAll('tr.draggable-row'));
                    updatedRows.forEach((r, idx) => {
                        let input = r.querySelector('.display-order-input');
                        if (input) input.value = idx + 1;
                    });

                    // Save new order to server
                    let newOrder = updatedRows.map(r => r.dataset.id);
                    saveEoiOrder({ order: newOrder });
                });
            });

            // Input event handler for manual number change
            tbody.querySelectorAll('.display-order-input').forEach(function(input) {
                input.addEventListener('change', function() {
                    let id = this.dataset.id;
                    let val = parseInt(this.value) || 0;
                    saveEoiOrder({ id: id, display_order: val, refresh: true });
                });
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        this.blur();
                      e.preventDefault();
                    }
                });
            });
        }

        function saveEoiOrder(data) {
            fetch("{{ route('admin.finance.eoi.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success') {
                    toastr.success('Display order updated successfully.');
                    if (data.refresh) {
                        // Reload current tab content
                        let activeTabUrl = $(".tab-btn.active").data("url");
                        if (activeTabUrl) {
                            $.get(activeTabUrl, function (res) {
                                $("#ajaxContent").html(res);
                            });
                        }
                    }
                } else {
                    toastr.error('Failed to update display order.');
                }
            })
            .catch(error => {
                console.error('Error updating order:', error);
                toastr.error('Error saving new order.');
            });
        }
    })();
</script>
