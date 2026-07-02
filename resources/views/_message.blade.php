<script>
  document.addEventListener('DOMContentLoaded', function () {

    if (typeof toastr === 'undefined') {
      console.error('Toastr is not loaded');
      return;
    }

    @if(session()->has('success'))
      toastr.success(@json(session('success')));
    @endif

    @if(session()->has('error'))
      toastr.error(@json(session('error')));
    @endif

    @if($errors->any())
      @foreach($errors->all() as $error)
        toastr.error(@json($error));
      @endforeach
    @endif

    @if(session()->has('warning'))
      toastr.warning(@json(session('warning')));
    @endif

    @if(session()->has('info'))
      toastr.info(@json(session('info')));
    @endif

});
</script>