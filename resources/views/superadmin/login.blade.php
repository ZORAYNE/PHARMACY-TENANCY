@if(!Auth::guard('superadmin')->check())
    <!-- Modal -->
    <div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Super Admin Login</h2>
                <a href="#" id="closeModal" class="text-gray-500 hover:text-gray-700">&times;</a>
            </div>
            <form method="POST" action="{{ route('superadmin.login.submit') }}">
                @csrf
                <input type="email" name="email" placeholder="Super Admin Email" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
                <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
                <button type="submit" class="w-full p-2 bg-blue-600 text-white rounded">Login</button>
            </form>
            <div class="text-center mt-4">
                <a href="{{ route('google.login') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303C34.29,32.292,29.585,36,24,36c-6.627,0-12-5.373-12-12s5.373-12,12-12c3.059,0,5.838,1.154,7.938,3.043l5.656-5.656C34.058,6.053,29.294,4,24,4C12.954,4,4,12.954,4,24s8.954,20,20,20c11.046,0,20-8.954,20-20C44,22.659,43.862,21.355,43.611,20.083z"/>
                        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.49,16.038,18.961,12,24,12c3.059,0,5.838,1.154,7.938,3.043l5.656-5.656C34.058,6.053,29.294,4,24,4C16.316,4,9.585,8.638,6.306,14.691z"/>
                        <path fill="#4CAF50" d="M24,44c5.231,0,9.918-1.969,13.525-5.188l-6.238-5.238C29.585,36,24,36,18.303,32.292l-6.577,5.07C11.934,40.255,17.642,44,24,44z"/>
                        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303C34.806,32.291,30,36,24,36c-3.59,0-6.839-1.417-9.214-3.708l-6.577,5.07C12.058,42.216,17.642,46,24,46c11.046,0,20-8.954,20-20C44,22.659,43.862,21.355,43.611,20.083z"/>
                    </svg>
                    Sign in with Google
                </a>
            </div>
        </div>
    </div>

    <script>
        // Close the modal when the close button is clicked
        document.getElementById('closeModal').onclick = function(event) {
            event.preventDefault();
            document.getElementById('loginModal').classList.add('hidden');
        };
    </script>

@else
    <script>
        // Redirect to the superadmin dashboard if already logged in
        window.location.href = "{{ route('superadmin.dashboard') }}";
    </script>
@endif
