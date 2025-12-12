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

  



<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card radius-10 shadow border-start">
                <div class="card-body">
                    <h5 class="mb-4 text-center">Change Password</h5>

                    {{-- Show validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Show success message --}}
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Change password form --}}
                    <form method="POST" action="{{ route('updatePassword') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark px-4">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

            
        

    

        
@endsection