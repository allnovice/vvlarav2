# Security Operations Center (SOC)

## Objective

Establish a centralized security dashboard for the CMMS infrastructure to monitor system health, vulnerabilities, security events, and operational risks.

## Scope

This dashboard focuses on infrastructure and security monitoring rather than application functionality.

## Planned Components

### Vulnerability Management
- [*] Trivy (Docker image CVE scanning)
- [ ] Docker Scout (optional)
- [ ] Operating system updates

### Infrastructure Health
- [*] Server CPU, Memory, Disk
- [ ] Docker container status
- [ ] Service availability
- [ ] Backup status

### Security Monitoring
- [ ] Critical Laravel logs
- [ ] Nginx error logs
- [ ] SSH login activity
- [ ] Failed authentication attempts

### Compliance & Hardening
- [ ] Lynis security audit
- [ ] SSL certificate expiration
- [*] Security score summary

### Dashboard
- [*] Build Grafana Security Operations dashboard
