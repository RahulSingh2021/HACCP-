@extends('layouts.app1', ['pagetitle' => 'Dashboard'])

@section('content')
<style>
  .tab-active {
    @apply text-blue-600 border-b-2 border-blue-600 bg-blue-50;
  }
  
  .loader span {
    animation: pulse 1.5s infinite;
  }

  @keyframes pulse {
    0% { opacity: 0.2; }
    50% { opacity: 1; }
    100% { opacity: 0.2; }
  }
</style>

<div class="row">
  <div class="mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg">

    <!-- Tabs -->
    <div class="flex flex-wrap justify-start border-b border-gray-200 mb-6 space-x-2 md:space-x-4" id="tabs">
      @php
        $tabs = [
          'supplier' => '📦 Supplier List',
          'supplier_all' => '📦 Supplier All',
          'brand' => '📦 Brand',
          'raw' => '🌾 Raw Material',
          'raw_all' => '🌾 Raw Material All',
          'fgc' => '🧪 FGC',
          'service' => '🛠️ Service',
          'spec' => '📄 Specification',
          'interactive_stock' => '📄 Interactive Stock',
          'yield_raw' => '🌾 Yield Raw Material',
          'receiving_record_new' => '📄 Receiving Record New',
        ];
      @endphp

      @foreach ($tabs as $key => $label)
        <button class="tab-btn flex items-center space-x-2 px-4 py-2 rounded-t-md text-sm font-medium hover:bg-blue-50" data-tab="{{ $key }}">
          <span>{!! explode(' ', $label)[0] !!}</span><span>{{ implode(' ', array_slice(explode(' ', $label), 1)) }}</span>
        </button>
      @endforeach
    </div>

    <!-- Tab Contents -->
    <div id="tab-contents">

      @foreach ($tabs as $key => $label)
      <div id="{{ $key }}" class="tab-content transition-opacity duration-300 hidden">
        <div class="loader flex justify-center items-center h-screen">
          <span class="text-blue-600 text-lg font-semibold">Loading...</span>
        </div>
        @if(in_array($key, ['fgc', 'service']))
          <!-- Static content for fgc and service -->
          <div class="hidden h-screen overflow-y-auto px-6 py-10">
            @if($key === 'fgc')
              <h2 class="text-2xl font-semibold mb-3">Finished Goods Control (FGC)</h2>
              <p class="text-gray-600">Quality control procedures, testing criteria, and inspection logs.</p>
            @elseif($key === 'service')
              <h2 class="text-2xl font-semibold mb-3">Service</h2>
              <p class="text-gray-600">Service providers, maintenance records, and SLAs.</p>
            @endif
          </div>
        @else
          <!-- Iframe content for other tabs -->
          <iframe src="{{ 
            match($key) {
              'supplier' => route('sqa.suplier.list'),
              'supplier_all' => route('sqa.suplier.all.list'),
              'brand' => route('sqa.suplier.brand'),
              'raw' => route('supplier.raw'),
              'raw_all' => route('supplier.raw.all'),
              'spec' => route('supplier_vendor_manage'),
              'interactive_stock' => route('advance.interactive.stock.register'),
              'yield_raw' => route('yield.raw.mat'),
              'receiving_record_new' => route('receiving.record.new'),
              default => '#',
            } 
          }}" class="w-full h-screen border hidden"></iframe>
        @endif
      </div>
      @endforeach

    </div>
  </div>
</div>
@endsection

@section('footerscript')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn3.devexpress.com/jslib/19.1.8/js/dx.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.7.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const tabs = document.querySelectorAll(".tab-btn");
  const contents = document.querySelectorAll(".tab-content");

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      // Remove active class from all tabs
      tabs.forEach(t => t.classList.remove("tab-active"));

      // Hide all contents and show their loaders, hide iframe/static content
      contents.forEach(content => {
        content.classList.add("hidden");

        const loader = content.querySelector(".loader");
        if (loader) loader.classList.remove("hidden");

        const iframe = content.querySelector("iframe");
        if (iframe) iframe.classList.add("hidden");

        const staticContent = content.querySelector("div:not(.loader)");
        if (staticContent) staticContent.classList.add("hidden");
      });

      // Activate clicked tab
      tab.classList.add("tab-active");

      const tabId = tab.dataset.tab;
      const content = document.getElementById(tabId);

      if (!content) return;

      const loader = content.querySelector(".loader");
      const iframe = content.querySelector("iframe");
      const staticContent = content.querySelector("div:not(.loader)");

      // Show tab content and loader, hide iframe/static content initially
      content.classList.remove("hidden");

      if (loader) loader.classList.remove("hidden");
      if (iframe) iframe.classList.add("hidden");
      if (staticContent) staticContent.classList.add("hidden");

      // After delay, hide loader, show iframe or static content
      setTimeout(() => {
        if (loader) loader.classList.add("hidden");
        if (iframe) iframe.classList.remove("hidden");
        if (staticContent) staticContent.classList.remove("hidden");
      }, 1000);
    });
  });

  // Trigger click on first tab on page load
  tabs[0].click();
});
</script>
@endsection
