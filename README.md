![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![Vue](https://img.shields.io/badge/Vue-3-42b883)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?logo=docker)
![CI](https://github.com/allnovice/vvlarav2/actions/workflows/laravel.yml/badge.svg)
![License](https://img.shields.io/badge/License-MIT-green)
![Repo Size](https://img.shields.io/github/repo-size/allnovice/vvlarav2)
![Last Commit](https://img.shields.io/github/last-commit/allnovice/vvlarav2)

📦 CMMS - Computerized Maintenance Management System

A modern web-based Computerized Maintenance Management System (CMMS) built with Laravel, Vue.js, and Inertia.js for managing organizational assets, users, approvals, and maintenance records.

Designed for government offices and organizations requiring a secure, approval-driven asset management workflow.

---

Overview

This project provides a centralized platform for managing organizational assets throughout their lifecycle.

The application focuses on accountability by introducing approval workflows, asset history tracking, audit trails, and role-based permissions while maintaining a clean and responsive interface.

---

Features

Asset Management

- Asset registration
- Asset editing with approval workflow
- Asset archival
- Asset photo management
- Multiple additional photos
- Thumbnail generation for faster loading
- Asset ownership and location tracking
- Complete asset history

Asset Verification

- Asset verification requests
- Verification approval workflow
- Verification history
- Pending verification dashboard

Asset Change Approval

Changes to critical asset information require approval before becoming permanent.

Supported approvals include:

- Asset information updates
- Photo changes
- Asset creation
- Asset deletion

---

User Management

- User profiles
- Department management
- Position management
- Role management
- Active / Inactive accounts
- Administrator user management

---

Authentication

- Email & Password authentication
- Google Sign-In
- Email verification
- Remember Me support
- Inactive account protection
- Role-based authorization (RBAC)

Inactive users are prevented from signing in regardless of authentication method.

---

Dashboard

Dashboard includes live statistics such as:

- Total Assets
- Active Assets
- Under Repair Assets
- Borrowed Assets
- Archived Assets
- Maintenance Coverage
- Pending Asset Changes
- Pending Photo Approvals
- Pending Verification Requests
- Pending User Approvals
- Recent Activities

---

Approval Workflow

The application includes approval-based workflows to protect important data.

Examples include:

- Asset modifications
- Asset verification
- Photo uploads
- User approval

This prevents accidental or unauthorized changes from immediately affecting production data.

---

Image Management

- Asset image uploads
- Automatic thumbnail generation
- Multiple asset photos
- Optimized image loading
- Pending image approval

---

Security

- CSRF Protection
- Laravel Authentication
- Email Verification
- Google OAuth
- Role-Based Access Control
- Inactive Account Enforcement
- Request Validation
- Audit History
- Secure Password Hashing

---

Technology Stack

Category| Technology
Backend| Laravel 13
Frontend| Vue 3
SPA Bridge| Inertia.js
Styling| Tailwind CSS
Database| MariaDB
Authentication| Laravel Auth + Google OAuth
Image Processing| Laravel Storage
Web Server| Nginx
Runtime| Docker
CI/CD| GitHub Actions
Virtualization| Proxmox VE

---

Architecture

                GitHub
                   │
          GitHub Actions
                   │
        Self-Hosted Runner
                   │
      (Ephemeral LXC Container)
                   │
        Deployment Webhook
      (Tailscale Funnel Secure Endpoint)
                   │
          Production VM
             Docker Compose
                   │
     ┌─────────────┴─────────────┐
     │                           │
 Laravel App                 Nginx
     │
 MariaDB

---

Development Environment

Development is containerized using Docker.

Typical workflow:

Developer
    │
    ▼
Git Commit
    │
    ▼
GitHub
    │
    ▼
GitHub Actions
    │
    ▼
Run Tests
    │
    ▼
Build Docker Images

---

Production Deployment

Production is fully containerized.

Deployment includes:

- Laravel application container
- Nginx container
- MariaDB container
- Persistent Docker volumes
- Asset storage
- Automated database migrations
- Optimized production builds

Docker images are built, transferred, and deployed using Docker Compose.

---

CI/CD Pipeline

The project uses a self-hosted CI/CD pipeline.

Pipeline stages include:

- Install dependencies
- Composer validation
- NPM build
- Laravel tests
- Docker image build
- Image export
- Production deployment

Deployment automation uses:

- GitHub Actions
- Self-hosted ephemeral runners
- Proxmox LXC containers
- Tailscale Funnel for secure webhook exposure

---

Infrastructure

Current infrastructure consists of:

- Development VM
- Staging VM
- Production VM
- Self-hosted GitHub Runner LXC
- Proxmox Virtual Environment

This architecture allows isolated development, testing, and production deployments.

---

Project Structure

app/
bootstrap/
config/
database/
docker/
public/
resources/
routes/
storage/
tests/

compose.prod.yaml
compose.stage.yaml
Dockerfile
README.md

---

Screenshots

Example screenshots to include:

- Login
- Dashboard
- Asset List
- Asset Details
- Asset Approval
- Asset Verification
- User Management
- Settings
- Mobile View

---

Roadmap

Planned Features

- Reports Module
- Excel Export
- Preventive Maintenance Scheduler
- Work Orders
- Notifications
- Email Notifications
- Equipment Lifecycle Tracking
- Asset QR Codes
- Barcode Support
- Asset Labels
- Dashboard Analytics
- Advanced Search
- Server Monitoring Dashboard
- Automated Backups
- High Availability Deployment
- Multi-node Deployment
- API Integration
- Mobile-Friendly Improvements

---

Security Highlights

✔ Email verification

✔ Google OAuth

✔ Secure password hashing

✔ Role-based authorization

✔ Approval workflows

✔ Inactive account enforcement

✔ Audit history

✔ Request validation

✔ Dockerized production environment

---

Why This Project?

This project was developed not only as an internal CMMS solution but also as an opportunity to explore modern self-hosted infrastructure and deployment practices.

Beyond application development, the project demonstrates experience with:

- Laravel architecture
- Vue.js and Inertia.js
- Docker containerization
- GitHub Actions
- Self-hosted CI/CD
- Proxmox virtualization
- Secure deployment pipelines
- Approval-based business workflows
- Production-ready application deployment

---

Future Vision

The long-term goal is to evolve this project into a full-featured enterprise CMMS capable of supporting preventive maintenance, reporting, asset lifecycle management, monitoring, high availability, and scalable deployments while remaining entirely self-hosted.

---

License

This project is licensed under the MIT License.
