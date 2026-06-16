
    @php
        $role = strtolower(auth()->user()->role);
        $routeName = $role . '.evaluasi.index';
        $indexRoute = \Illuminate\Support\Facades\Route::has($routeName)
            ? route($routeName)
            : route('guru.evaluasi.index');
    @endphp

    
        
            
                
                    {{ __('Evaluasi Keputusan Panen Akhir') }}
                
                
                    Dashboard
                    
                        
                    
                    Evaluasi Panen Akhir
                