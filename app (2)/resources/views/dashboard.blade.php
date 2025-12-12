@extends('layouts.app', ['pagetitle'=>'Dashboard'])
<style>
    p.my-1.text-info1 {
    font-weight: 400;
    color: #6c757d;
}
p.mb-0.text-info1 {
    font-weight: 400;
    color: #6c757d;
}
.buttons {
    margin: 11px 0px;
}

.upersection .card-body {
    height: 163px;
}
.box {
    margin: 3px 0px;
    padding: 2px;
}

    .dashboard-container {
      display: flex;
      overflow-x: auto;
      padding-bottom: 20px;
      gap: 1.5rem;
      scrollbar-width: thin;
      scrollbar-color: #cbd5e0 #f1f5f9;
    }
    .dashboard-container::-webkit-scrollbar {
      height: 8px;
    }
    .dashboard-container::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    .dashboard-container::-webkit-scrollbar-thumb {
      background-color: #cbd5e0;
      border-radius: 20px;
    }
    .dashboard-card {
      width: auto;
      height: 380px;
      flex: 0 0 auto;
    }
    
       .dashboard-container {
      display: flex;
      overflow-x: auto;
      padding-bottom: 20px;
      gap: 1.5rem;
      scrollbar-width: thin;
      scrollbar-color: #cbd5e0 #f1f5f9;
    }
    .dashboard-container::-webkit-scrollbar {
      height: 8px;
    }
    .dashboard-container::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    .dashboard-container::-webkit-scrollbar-thumb {
      background-color: #cbd5e0;
      border-radius: 20px;
    }
    .dashboard-card {
      width: auto;
      height: 380px;
      flex: 0 0 auto;
    }

</style>

<script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            fssai: '#8B5CF6',
            culture: '#EC4899',
            training: '#6366F1',
            hygiene: '#10B981',
            supplier: '#F59E0B',
            progress: '#10B981',
            success: '#10B981',
            warning: '#EF4444'
          }
        }
      }
    }
  </script>
  
    <script>
    lucide.createIcons();
  </script>
@section('content')
 
   <div class="container-fluid  mx-auto">
    <div class="dashboard-container">
      <!-- FSSAI Compliance Card -->
      <div class="dashboard-card bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-start mb-3">
          <div>
            <h1 class="text-lg font-semibold text-gray-800">FSSAI COMPLIANCE</h1>
            <div class="flex items-baseline gap-2 mt-1">
              <span class="text-3xl font-bold text-fssai">93%</span>
              <span class="text-sm text-success font-medium flex items-center">
                <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                ✧ 2% from last month
              </span>
            </div>
          </div>
          <div class="bg-fssai/10 p-2 rounded-lg text-fssai">
            <i data-lucide="shield-check" class="w-5 h-5"></i>
          </div>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
          <div class="bg-progress h-2 rounded-full" style="width: 93%"></div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">LICENSE/HRA/TPA</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">FoSTaC</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Medical Report</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Sampling</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
        </div>
      </div>

      <!-- Food Safety Culture Card -->
      <div class="dashboard-card bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-start mb-3">
          <div>
            <h1 class="text-lg font-semibold text-gray-800">FOOD SAFETY CULTURE</h1>
            <div class="flex items-baseline gap-2 mt-1">
              <span class="text-3xl font-bold text-culture">93%</span>
              <span class="text-sm text-success font-medium flex items-center">
                <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                ✧ 2% from last month
              </span>
            </div>
          </div>
          <div class="bg-culture/10 p-2 rounded-lg text-culture">
            <i data-lucide="users" class="w-5 h-5"></i>
          </div>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
          <div class="bg-progress h-2 rounded-full" style="width: 93%"></div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Real Time Monitoring</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Responsiveness</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Willingness to report</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Critical Concern</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
        </div>
      </div>

      <!-- Competency Card -->
      <div class="dashboard-card bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-start mb-3">
          <div>
            <h1 class="text-lg font-semibold text-gray-800">COMPETENCY</h1>
            <div class="flex items-baseline gap-2 mt-1">
              <span class="text-3xl font-bold text-hygiene">93%</span>
              <span class="text-sm text-warning font-medium flex items-center">
                <i data-lucide="trending-down" class="w-4 h-4 mr-1"></i>
                ✧ 2% from last month
              </span>
            </div>
          </div>
          <div class="bg-hygiene/10 p-2 rounded-lg text-hygiene">
            <i data-lucide="spray-can" class="w-5 h-5"></i>
          </div>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
          <div class="bg-progress h-2 rounded-full" style="width: 93%"></div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Food Safety Team</p>
            <p class="text-lg font-semibold text-gray-800">18 <span class="text-gray-400">/ 20</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Executive</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Staff</p>
            <p class="text-lg font-semibold text-gray-800">18 <span class="text-gray-400">/ 20</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Contract/Trainee/Vendor</p>
            <p class="text-lg font-semibold text-gray-800">18 <span class="text-gray-400">/ 20</span></p>
          </div>
        </div>
      </div>

      <!-- Facility Hygiene Card -->
      <div class="dashboard-card bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-start mb-3">
          <div>
            <h1 class="text-lg font-semibold text-gray-800">FACILITY HYGIENE</h1>
            <div class="flex items-baseline gap-2 mt-1">
              <span class="text-3xl font-bold text-hygiene">93%</span>
              <span class="text-sm text-warning font-medium flex items-center">
                <i data-lucide="trending-down" class="w-4 h-4 mr-1"></i>
                ✧ 2% from last month
              </span>
            </div>
          </div>
          <div class="bg-hygiene/10 p-2 rounded-lg text-hygiene">
            <i data-lucide="spray-can" class="w-5 h-5"></i>
          </div>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
          <div class="bg-progress h-2 rounded-full" style="width: 93%"></div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Cleaning</p>
            <p class="text-lg font-semibold text-gray-800">18 <span class="text-gray-400">/ 20</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">PM</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Breakdown</p>
            <p class="text-lg font-semibold text-gray-800">18 <span class="text-gray-400">/ 20</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Calibration</p>
            <p class="text-lg font-semibold text-gray-800">18 <span class="text-gray-400">/ 20</span></p>
          </div>
        </div>
      </div>

      <!-- Supplier Quality Assurance Card -->
      <div class="dashboard-card bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-start mb-3">
          <div>
            <h1 class="text-lg font-semibold text-gray-800">SUPPLIER QUALITY</h1>
            <div class="flex items-baseline gap-2 mt-1">
              <span class="text-3xl font-bold text-supplier">93%</span>
              <span class="text-sm text-success font-medium flex items-center">
                <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                ✧ 2% from last month
              </span>
            </div>
          </div>
          <div class="bg-supplier/10 p-2 rounded-lg text-supplier">
            <i data-lucide="package-check" class="w-5 h-5"></i>
          </div>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
          <div class="bg-progress h-2 rounded-full" style="width: 93%"></div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">COA</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">FGC</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Vendor Audit</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
          <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500 font-medium">Non Compliance</p>
            <p class="text-lg font-semibold text-gray-800">86 <span class="text-gray-400">/ 92</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
              <div class="row p-4">

  <div class="cols-xl-4 bg-white rounded-xl shadow-md p-6 w-full max-w-sm hover:shadow-lg transition" style="margin:10px;">
    
    <!-- Header -->
    <div class="flex justify-between items-start mb-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kitchen Score Card</p>
        <div class="flex items-end gap-2 mt-1">
          <h2 class="text-3xl font-bold text-gray-800">93%</h2>
          <p class="text-xs font-medium text-danger flex items-center mb-1">
            <i data-lucide="trending-down" class="w-3 h-3 mr-1"></i>
            2% from last month
          </p>
        </div>
      </div>
      <div class="bg-primary/10 p-2 rounded-lg text-primary">
        <i data-lucide="spray-can" class="w-5 h-5"></i>
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
      <div class="bg-primary h-2 rounded-full" style="width: 93%"></div>
    </div>

    <!-- Divider -->
    <div class="my-4 border-t border-gray-100"></div>

    <!-- By Category -->
    <div class="space-y-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">By Category</p>
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-secondary/10 p-1.5 rounded-lg text-secondary">
                <i data-lucide="broom" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Observation Response Time</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">42</span>
              <span class="text-gray-400">/45</span>
            </div>
          </div>
          
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Food Safety Training</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
          
         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Pest COntrol</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
 

         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-danger/10 p-1.5 rounded-lg text-danger">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Issues Raised</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">7</span>
              <span class="text-gray-400">/8</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="cols-xl-4 bg-white rounded-xl shadow-md p-6 w-full max-w-sm hover:shadow-lg transition" style="margin:10px;">
    
    <!-- Header -->
    <div class="flex justify-between items-start mb-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">FB Service Card
</p>
        <div class="flex items-end gap-2 mt-1">
          <h2 class="text-3xl font-bold text-gray-800">93%</h2>
          <p class="text-xs font-medium text-danger flex items-center mb-1">
            <i data-lucide="trending-down" class="w-3 h-3 mr-1"></i>
            2% from last month
          </p>
        </div>
      </div>
      <div class="bg-primary/10 p-2 rounded-lg text-primary">
        <i data-lucide="spray-can" class="w-5 h-5"></i>
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
      <div class="bg-primary h-2 rounded-full" style="width: 93%"></div>
    </div>

    <!-- Divider -->
    <div class="my-4 border-t border-gray-100"></div>

    <!-- By Category -->
    <div class="space-y-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">By Category</p>
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-secondary/10 p-1.5 rounded-lg text-secondary">
                <i data-lucide="broom" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Observation Response Time</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">42</span>
              <span class="text-gray-400">/45</span>
            </div>
          </div>
          
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Food Safety Training</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
          
         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Pest COntrol</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
 

         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-danger/10 p-1.5 rounded-lg text-danger">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Issues Raised</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">7</span>
              <span class="text-gray-400">/8</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="cols-xl-4 bg-white rounded-xl shadow-md p-6 w-full max-w-sm hover:shadow-lg transition" style="margin:10px;">
    
    <!-- Header -->
    <div class="flex justify-between items-start mb-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kitchen Score Card</p>
        <div class="flex items-end gap-2 mt-1">
          <h2 class="text-3xl font-bold text-gray-800">93%</h2>
          <p class="text-xs font-medium text-danger flex items-center mb-1">
            <i data-lucide="trending-down" class="w-3 h-3 mr-1"></i>
            2% from last month
          </p>
        </div>
      </div>
      <div class="bg-primary/10 p-2 rounded-lg text-primary">
        <i data-lucide="spray-can" class="w-5 h-5"></i>
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
      <div class="bg-primary h-2 rounded-full" style="width: 93%"></div>
    </div>

    <!-- Divider -->
    <div class="my-4 border-t border-gray-100"></div>

    <!-- By Category -->
    <div class="space-y-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">By Category</p>
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-secondary/10 p-1.5 rounded-lg text-secondary">
                <i data-lucide="broom" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Observation Response Time</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">42</span>
              <span class="text-gray-400">/45</span>
            </div>
          </div>
          
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Food Safety Training</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
          
         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Pest COntrol</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
 

         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-danger/10 p-1.5 rounded-lg text-danger">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Issues Raised</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">7</span>
              <span class="text-gray-400">/8</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="cols-xl-4 bg-white rounded-xl shadow-md p-6 w-full max-w-sm hover:shadow-lg transition" style="margin:10px;">
    
    <!-- Header -->
    <div class="flex justify-between items-start mb-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kitchen Score Card</p>
        <div class="flex items-end gap-2 mt-1">
          <h2 class="text-3xl font-bold text-gray-800">93%</h2>
          <p class="text-xs font-medium text-danger flex items-center mb-1">
            <i data-lucide="trending-down" class="w-3 h-3 mr-1"></i>
            2% from last month
          </p>
        </div>
      </div>
      <div class="bg-primary/10 p-2 rounded-lg text-primary">
        <i data-lucide="spray-can" class="w-5 h-5"></i>
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
      <div class="bg-primary h-2 rounded-full" style="width: 93%"></div>
    </div>

    <!-- Divider -->
    <div class="my-4 border-t border-gray-100"></div>

    <!-- By Category -->
    <div class="space-y-4">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">By Category</p>
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-secondary/10 p-1.5 rounded-lg text-secondary">
                <i data-lucide="broom" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Observation Response Time</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">42</span>
              <span class="text-gray-400">/45</span>
            </div>
          </div>
          
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Food Safety Training</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
          
         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Pest COntrol</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>
 

         <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-warning/10 p-1.5 rounded-lg text-warning">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Cleaning</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">18</span>
              <span class="text-gray-400">/20</span>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm">
              <div class="bg-danger/10 p-1.5 rounded-lg text-danger">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
              </div>
              <span class="text-gray-700">Issues Raised</span>
            </div>
            <div class="text-sm font-medium text-gray-800">
              <span class="text-gray-900">7</span>
              <span class="text-gray-400">/8</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  </div>

 <!--<div class="row">-->
 <!--                                <h2 style="text-align: center;margin-bottom: 20px !important;">Unit Address: {{Auth::user()->Company_address ?? ''}}</h2>-->
                                 
 <!--                                </div>-->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 upersection">

                <div class="col">
                       
                    <div class="card radius-10 border-start">
                        <div class="card-body">
                                        

                            <div class="d-flex align-items-center">
                                
                                
                                <div>
                                    <p class="mb-0 text-secondary"><strong>FSSAI license</strong></p>
                                    <p class="my-0 text-info1">License Category : {{ Helper::getDocumentsLincesNumber(Auth::user()->id, 'Central', 'Unit','License')->cat_type ?? '' }}</p>
                                    <p class="mb-0 text-info1">License Number : {{ Helper::getDocumentsLincesNumber(Auth::user()->id, 'Central', 'Unit','License')->lincess_number ?? '' }}</p>
                                    <p class="mb-0 text-info1">Valid till : {{ Helper::getDocumentsLincesNumber(Auth::user()->id, 'Central', 'Unit','License')->due_date ?? '' }}</a></p>
                                    
                                    <div class="buttons">
                                    <a href="#" style="margin: 0px 15px 10px 0px;" class="btn-update">Update</a>
                                    <a href="{{route('allUnitHistory',[Auth::user()->id,'unit'])}}?document_type=License" style="margin: 0px 15px 10px 0px;"  class="btn-History">History</a>
                                    <a href="#" style="margin: 0px 15px 10px 0px;"  class="btn-License">View License</a>
                                    <a href="{{route('unitHistoryHra',[Auth::user()->id,'unit'])}}?document_type=License">
        Upload License
    </a>
                                    </div>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-cart'></i>
                                </div>
                                
                            </div>
                            <div class="box" style="height: 5px;background: #0d6efd;border-radius: 50px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary"><strong>HRA</strong></p>
                                    <p class="my-1 text-info1">Audit Date</p>
                                    <p class="mb-0 text-info1">Valid till</p>
                                    
                                    
                                    <div class="buttons">
                                    <a href="#" style="margin: 0px 15px 10px 0px;" class="btn-update">Update</a>
                                    <a href="{{route('allUnitHistory',[Auth::user()->id,'unit'])}}?document_type=HRA" style="margin: 0px 15px 10px 0px;color:#fd3550"  class="btn-History">History</a>
                                    <a href="{{ route('units', [Auth::user()->id, '1', 'pending']) }}?document_type=HRA" style="margin: 0px 15px 10px 0px;"  class="btn-License">View License</a>
                                     <a href="{{route('unitHistoryHra',[Auth::user()->id,'unit'])}}?document_type=HRA">
        Upload HRA
    </a>
                                    
                                    </div>
                                    
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bxs-wallet'></i>
                                </div>
                            </div>
                             <div class="box" style="height: 5px;background: #0d6efd;border-radius: 50px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary"><strong>TPA</strong></p>
                                    <p class="my-1 text-info1">Audit Date</p>
                                    <p class="mb-0 text-info1">Valid till</p>
                                         <a href="#">Update</a>
                                    <a href="{{route('allUnitHistory',[Auth::user()->id,'unit'])}}?document_type=TPA">History</a>
                                     <a href="{{ route('units', [Auth::user()->id, '1', 'pending']) }}?document_type=TPA">
        {{ Helper::units(Auth::user()->id, '1', 'pending','TPA') }} View License
    </a>
    <a href="{{route('unitHistoryHra',[Auth::user()->id,'unit'])}}?document_type=TPA">
        Upload License
    </a>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                                </div>
                            </div>
                             <div class="box" style="height: 5px;background: #0d6efd;border-radius: 50px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    
                                     @php $totalEmploye = Helper::totalunitfostag(Auth::user()->id) @endphp
                                    <p class="mb-0 text-secondary"><strong>FoSTaC</strong></p>
                                   <p class="my-1 text-info1">Food Handlers Count:<a href="">{{$totalEmploye ?? 0}}</a> ,Certificate Requried: @if($totalEmploye > 0) <a href="">{{$totalEmploye/25}}</a> @else <a href="">0</a> @endif</p>
                                    <p class="mb-0 text-info1">Total Certificate:</p>
                                    <p class="mb-0 text-info1">Expired:1</p>
                                    
                                    <a href="{{route('uploadFoSTaC',[Auth::user()->id,'unit'])}}">uploadFoSTaC</a>
                                        
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-group'></i>
                                </div>
                            </div>
                            <div class="box" style="height: 5px;background: #0d6efd;border-radius: 50px;"></div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Sales Overview</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Sales</span>
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Visits</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">24.15M</h5>
                                    <small class="mb-0">Overall Visitor <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">12:38</h5>
                                    <small class="mb-0">Visitor Duration <span> <i class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">639.82</h5>
                                    <small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Trending Products</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-container-2 mt-4">
                                <canvas id="chart2"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Jeans <span class="badge bg-success rounded-pill">25</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">T-Shirts <span class="badge bg-danger rounded-pill">10</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Shoes <span class="badge bg-primary rounded-pill">65</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Lingerie <span class="badge bg-warning text-dark rounded-pill">14</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!--end row-->


           <div class="row row-cols-1 row-cols-lg-3">
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <p class="font-weight-bold mb-1 text-secondary">Weekly Revenue</p>
                            <div class="d-flex align-items-center mb-4">
                                <div>
                                    <h4 class="mb-0">$89,540</h4>
                                </div>
                                <div class="">
                                    <p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i class="bx bxs-up-arrow-alt mr-2"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="chart-container-0">
                                <canvas id="chart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Orders Summary</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-1">
                                <canvas id="chart4"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Top Selling Categories</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-0">
                                <canvas id="chart5"></canvas>
                            </div>
                        </div>
                        <div class="row row-group border-top g-0">
                            <div class="col">
                                <div class="p-3 text-center">
                                    <h4 class="mb-0 text-danger">$45,216</h4>
                                    <p class="mb-0">Clothing</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3 text-center">
                                    <h4 class="mb-0 text-success">$68,154</h4>
                                    <p class="mb-0">Electronic</p>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
            </div><!--end row-->

        
@endsection