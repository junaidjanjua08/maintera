@extends('index')

@section('content')
<div
      class="container-fluid page-header py-5 mb-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4">
          My Profile
        </h1>
        <nav aria-label="breadcrumb animated slideInDown">
          <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item">
              <a class="text-white" href="#">Home</a>
            </li>
            <li class="breadcrumb-item text-primary active" aria-current="page">
              Profile
            </li>
          </ol>
        </nav>
      </div>
    </div>
<div class="container">
    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <h2>👤 My Profile</h2>
            <p>Update your personal information</p>
        </div>
        
        {{-- Profile Update Form --}}
        <form method="POST" action="{{ route('profile.update') }}" class="form">
            @csrf
            @method('PATCH')

            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="verify-warning">
                        Your email is unverified.
                        <form method="POST" action="{{ route('verification.send') }}" class="inline">
                            @csrf
                            <button type="submit" class="verify-btn">Resend verification</button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="form-footer">
                <button type="submit" class="save-btn">💾 Save Changes</button>

                @if (session('status') === 'profile-updated')
                    <p class="success-message">✔️ Profile successfully updated!</p>
                @endif
            </div>
        </form>
    </div>

    <!-- Change Password Card -->
    <div class="password-card">
        <h2>🔐 Change Password</h2>

        <form method="POST" action="{{ route('password.update') }}" class="form">
            @csrf
            @method('PUT')

            <div class="input-group">
                <label>Current Password</label>
                <input type="password" name="current_password" autocomplete="current-password">
                @if ($errors->updatePassword->has('current_password'))
                    <p class="error">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="password" autocomplete="new-password">
                @if ($errors->updatePassword->has('password'))
                    <p class="error">{{ $errors->updatePassword->first('password') }}</p>
                @endif
            </div>

            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" autocomplete="new-password">
                @if ($errors->updatePassword->has('password_confirmation'))
                    <p class="error">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                @endif
            </div>

            <div class="form-footer">
                <button type="submit" class="save-btn">🔒 Update Password</button>

                @if (session('status') === 'password-updated')
                    <p class="success-message">✔️ Password successfully updated!</p>
                @endif
            </div>
        </form>
    </div>

    <!-- Delete Account Card -->
    <div class="delete-card">
        <h2>⚠️ Delete Account</h2>
        <p class="warning-text">This action is irreversible. Your data will be permanently deleted.</p>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account?');">
            @csrf
            @method('DELETE')

            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="password" class="delete-input">
                @if ($errors->userDeletion->has('password'))
                    <p class="error">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <button type="submit" class="delete-btn">❌ Permanently Delete Account</button>
        </form>
    </div>
</div>

<style>
/* Container for the profile management sections */
.container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    padding: 2rem;
    max-width: 100%;
    margin: auto;
    align-items: center;
}

/* General styling for all cards */
.profile-card, .password-card, .delete-card {
    width: 100%;
    max-width: 1200px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin: 1rem 0;
}

/* Hover effect for cards */
.profile-card:hover, .password-card:hover, .delete-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Header styles */
.profile-header h2, .password-card h2, .delete-card h2 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 1rem;
    font-weight: bold;
}

.profile-header p, .warning-text {
    color: #888;
    font-size: 1rem;
}

/* Input group styling */
.input-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.input-group label {
    font-weight: bold;
    color: #333;
    display: block;
    margin-bottom: 0.5rem;
}

/* Form inputs styling */
.input-group input {
    width: 100%;
    padding: 1rem;
    border: 2px solid #ccc;
    border-radius: 10px;
    font-size: 1.1rem;
    color: #333;
    transition: border-color 0.3s ease;
}

.input-group input:focus {
    border-color: #4c8bf5;
    outline: none;
}

/* Buttons */
.save-btn, .delete-btn, .verify-btn {
    background-color: #4c8bf5;
    color: white;
    padding: 1rem;
    width: 100%;
    border-radius: 10px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.save-btn:hover, .delete-btn:hover, .verify-btn:hover {
    background-color: #0066cc;
    transform: scale(1.05);
}

.success-message {
    color: #28a745;
    font-size: 1rem;
    margin-top: 1rem;
}

.error {
    color: #e74c3c;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.verify-warning {
    color: #f1c40f;
    font-size: 0.9rem;
    margin-top: 1rem;
}

.delete-input {
    background-color: #f9e0e0;
    border: 2px solid #f59c42;
    color: #e74c3c;
    padding: 1rem;
    font-size: 1rem;
    border-radius: 10px;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
    padding: 1.2rem;
    width: 100%;
    border-radius: 10px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.delete-btn:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}
</style>
@endsection
