@include('layouts.header')
<div class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h3>Edit Profile</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $employee->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $employee->email) }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Photo</label><br>
                <img src="{{ $employee->profile_photo_url ?? asset('assets/img/avatar/avatar-25.png') }}"
                     alt="Profile" width="80" class="rounded mb-2">
                <input type="file" name="profile_photo" class="form-control">
                @error('profile_photo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <hr>
            <h5>Change Password</h5>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter new password">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

@include('layouts.footer')