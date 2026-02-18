# Password Reset System Feature Extraction Plan

## Task: Extract Password Reset System from Laravel Project to CodeVault

## 1. Information Gathered

### Current Implementation Analysis:

#### Controller (app/Http/Controllers/AuthController.php):
- `ResetPassword()` - Displays forgot password form
- `sendResetCode(Request $request)` - Validates email, generates 64-char token, stores in DB, sends email
- `showResetForm($token)` - Validates token exists and not expired (60 min), displays password change form
- `updatePassword(Request $request)` - Validates token/email, updates password, deletes token

#### Mail (app/Mail/ResetPasswordMail.php):
- Mailable class that sends password reset email with token

#### Views:
- `resources/views/auth/resetpassword.blade.php` - Forgot password input form
- `resources/views/auth/changepassword.blade.php` - New password form with email/password/confirmation
- `resources/views/emails/passwordreset.blade.php` - HTML email template with reset link

#### Routes (routes/web.php):
- `GET /reset` - Forgot password page
- `POST /send-Reset-Code` - Send reset email
- `GET /reset-password/{token}` - Reset password form
- `POST /reset-password` - Update password

#### Database (database/migrations/0001_01_01_000000_create_users_table.php):
- `password_reset_tokens` table: email (primary), token, created_at

## 2. Plan

### Step 1: Create reusable Controller trait
- Create PasswordResetTrait.php with all password reset methods
- Make methods generic with configurable token expiration
- Use dependency injection for Mail and DB

### Step 2: Create reusable Mailable
- Create generic ResetPasswordMailable.php
- Make subject configurable
- Use generic view path

### Step 3: Create Blade templates
- Create generic forgot_password.blade.php
- Create generic reset_password_form.blade.php
- Create generic password_reset_email.blade.php

### Step 4: Create migration file
- Create migration for password_reset_tokens table

### Step 5: Create routes file
- Create example routes for password reset

### Step 6: Document terminal commands
- List all necessary commands for setup

## 3. Dependent Files to be Created

- app/Http/Controllers/Auth/PasswordResetTrait.php
- app/Mail/PasswordResetMailable.php
- resources/views/auth/password/forgot_password.blade.php
- resources/views/auth/password/reset_password_form.blade.php
- resources/views/emails/password_reset.blade.php
- database/migrations/xxxx_xx_xx_create_password_reset_tokens_table.php
- routes/password_reset.php

## 4. Followup Steps

- [] Create reusable controller trait
- [] Create reusable mail class
- [] Create Blade templates
- [] Create migration file
- [] Create routes file
- [] Document terminal commands
