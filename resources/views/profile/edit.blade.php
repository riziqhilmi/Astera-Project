@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Profile Banner Section -->
        <div class="relative bg-gradient-to-r from-blue-200 via-green-200 via-yellow-200 to-orange-200 rounded-2xl p-8 mb-8 overflow-hidden">
            <!-- Camera Icon for Banner -->
            <button id="bannerCameraBtn" class="absolute top-4 right-4 p-2 bg-white bg-opacity-80 rounded-full hover:bg-opacity-100 transition-all hover:scale-110">
                <i class="fas fa-camera text-gray-600"></i>
            </button>
            
            <!-- Hidden file input for banner -->
            <input type="file" id="bannerInput" accept="image/*" class="hidden">
            
            <div class="flex items-center gap-6">
                <!-- Large Profile Picture -->
                <div class="relative">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                    <button id="profileCameraBtn" class="absolute bottom-0 right-0 p-2 bg-teal-500 text-white rounded-full hover:bg-teal-600 transition-colors hover:scale-110">
                        <i class="fas fa-camera text-sm"></i>
                    </button>
                </div>
                
                <!-- Profile Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Setting</h1>
                    <p class="text-gray-600">{{ Auth::user()->email ?? 'Hendrickmoseng@gmail.com' }}</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button id="cancelBtn" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all hover:-translate-y-0.5">
                        Cancel
                    </button>
                    <button id="saveBtn" class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all hover:-translate-y-0.5 shadow-lg">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-8">
            <nav class="flex space-x-8">
                <button id="profileTab" class="py-2 px-1 border-b-2 border-teal-500 text-teal-500 font-medium transition-all cursor-pointer" data-tab="profile">
                    Profile
                </button>
                <button id="passwordTab" class="py-2 px-1 border-b-2 border-transparent text-gray-500 font-medium transition-all cursor-pointer hover:text-gray-700 hover:border-gray-300" data-tab="password">
                    Password
                </button>
            </nav>
        </div>

        <!-- Profile Form -->
        <div id="profileContent" class="bg-white rounded-lg shadow-sm border p-8 transition-all">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Profile</h2>
                <p class="text-gray-600">Update your photo and personal details.</p>
            </div>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Username -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? 'Hendrick Moseng') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                           placeholder="Enter your username">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                    <div class="flex items-center gap-4">
                        <img id="profileImage" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="w-16 h-16 rounded-full border-2 border-gray-200 object-cover">
                        <div class="flex gap-3">
                            <button id="editProfileBtn" type="button" class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all hover:scale-105">
                                Edit
                            </button>
                            <button id="deleteProfileBtn" type="button" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all hover:scale-105">
                                Delete
                            </button>
                        </div>
                    </div>
                    <!-- Hidden file input for profile picture -->
                    <input type="file" id="profileInput" accept="image/*" class="hidden">
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <div class="flex">
                        <div class="flex items-center px-3 py-2 border border-r-0 border-gray-300 rounded-l-lg bg-gray-50 text-gray-700 font-medium">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="w-5 h-3 mr-2">
                            <span>+62</span>
                        </div>
                        <input type="tel" id="phone" name="phone" value="851-894-2348"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                               placeholder="Enter phone number">
                    </div>
                </div>

                <!-- Contact Email -->
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="contact_email" name="contact_email" value="{{ Auth::user()->email ?? 'example@example.com' }}"
                               class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                               placeholder="Enter contact email">
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit" class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all hover:-translate-y-0.5 shadow-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Form -->
        <div id="passwordContent" class="bg-white rounded-lg shadow-sm border p-8 transition-all hidden">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Password</h2>
                <p class="text-gray-600">Update your password to keep your account secure.</p>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input type="password" id="current_password" name="current_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                           placeholder="Enter current password">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                           placeholder="Enter new password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                           placeholder="Confirm new password">
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit" class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all hover:-translate-y-0.5 shadow-lg">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account Section -->
        <div class="bg-white rounded-lg shadow-sm border p-8 transition-all hover:shadow-md">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Delete Account</h3>
                    <p class="text-sm text-gray-600">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                </div>
                <button class="px-4 py-2 text-red-600 hover:text-red-800 font-medium hover:bg-red-50 rounded-lg transition-all">
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Profile page loaded successfully');
        
        const profileTab = document.getElementById('profileTab');
        const passwordTab = document.getElementById('passwordTab');
        const profileContent = document.getElementById('profileContent');
        const passwordContent = document.getElementById('passwordContent');

        if (!profileTab || !passwordTab || !profileContent || !passwordContent) {
            console.error('Some elements not found:', { profileTab, passwordTab, profileContent, passwordContent });
            return;
        }

        function switchTab(tabName) {
            console.log('Switching to tab:', tabName);
            
            // Hide all content
            document.querySelectorAll('#profileContent, #passwordContent').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tabs
            document.querySelectorAll('#profileTab, #passwordTab').forEach(tab => {
                tab.classList.remove('border-teal-500', 'text-teal-500');
                tab.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected content and activate tab
            if (tabName === 'profile') {
                profileContent.classList.remove('hidden');
                profileTab.classList.remove('border-transparent', 'text-gray-500');
                profileTab.classList.add('border-teal-500', 'text-teal-500');
            } else if (tabName === 'password') {
                passwordContent.classList.remove('hidden');
                passwordTab.classList.remove('border-transparent', 'text-gray-500');
                passwordTab.classList.add('border-teal-500', 'text-teal-500');
            }
        }

        profileTab.addEventListener('click', () => switchTab('profile'));
        passwordTab.addEventListener('click', () => switchTab('password'));

        // Profile picture edit functionality
        const editProfileBtn = document.getElementById('editProfileBtn');
        const deleteProfileBtn = document.getElementById('deleteProfileBtn');
        const profileImage = document.getElementById('profileImage');
        const profileInput = document.getElementById('profileInput');

        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', function() {
                profileInput.click();
            });
        }

        if (deleteProfileBtn) {
            deleteProfileBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete your profile picture?')) {
                    profileImage.src = 'https://randomuser.me/api/portraits/men/32.jpg';
                }
            });
        }

        if (profileInput) {
            profileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Save and Cancel functionality
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        if (saveBtn) {
            saveBtn.addEventListener('click', function() {
                // Show success message
                showNotification('Profile updated successfully!', 'success');
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                // Reset form to original values
                if (confirm('Are you sure you want to cancel? All changes will be lost.')) {
                    location.reload();
                }
            });
        }

        // Notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full`;
            
            if (type === 'success') {
                notification.className += ' bg-green-500 text-white';
            } else if (type === 'error') {
                notification.className += ' bg-red-500 text-white';
            } else {
                notification.className += ' bg-blue-500 text-white';
            }
            
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Banner image change functionality
        const bannerCameraBtn = document.getElementById('bannerCameraBtn');
        const bannerInput = document.getElementById('bannerInput');
        const profileCameraBtn = document.getElementById('profileCameraBtn');

        if (bannerCameraBtn) {
            bannerCameraBtn.addEventListener('click', function() {
                bannerInput.click();
            });
        }

        if (profileCameraBtn) {
            profileCameraBtn.addEventListener('click', function() {
                profileInput.click();
            });
        }

        if (bannerInput) {
            bannerInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update banner background
                        const banner = document.querySelector('.bg-gradient-to-r');
                        banner.style.backgroundImage = `url(${e.target.result})`;
                        banner.style.backgroundSize = 'cover';
                        banner.style.backgroundPosition = 'center';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection
