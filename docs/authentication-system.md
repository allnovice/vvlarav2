# Authentication System

## Overview

The CMMS authentication system uses Laravel's built-in authentication features with email verification and password reset.

## Features

* User registration
* Email and password login
* Google login
* Email verification
* Forgot password
* Password reset via email
* Change password
* Remember Me
* Account activation (`is_active`)

## Email Verification

New users must verify their email address before accessing protected areas of the application.

Verified routes are protected using Laravel's `verified` middleware.

## Password Reset

Users can request a password reset from the login page.

Password reset emails are delivered through the configured SMTP relay.

## Email Address Policy

User email addresses are treated as permanent account identifiers.

Users cannot modify their email address from their profile.

Administrators also cannot modify user email addresses.

This prevents:

* Broken Google account associations
* Invalid email verification state
* Password reset inconsistencies
* Account identity changes

If an email address must be changed, it should be handled through a dedicated administrative migration process.

## Password Storage

Passwords are never stored in plain text.

Laravel stores passwords using secure one-way hashing.

Google authentication never exposes or stores a user's Google password within the CMMS.

## Account Status

Accounts can be disabled by administrators using the `is_active` flag.

Disabled users cannot sign in even if their credentials are valid.

## Authentication Flow

### Email Login

Register

→ Verify email

→ Login

→ Access protected pages

### Password Recovery

Forgot Password

→ Receive reset email

→ Set a new password

→ Login

### Google Login

Sign in with Google

→ Google authenticates the user

→ CMMS signs the user in

The user's Google password is never transmitted to or stored by the CMMS.
