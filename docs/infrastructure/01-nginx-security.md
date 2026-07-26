# 01 - Nginx Security

## Objective

Implement Nginx security controls to reduce abusive traffic before requests reach the Laravel application.

## Scope

- Request rate limiting
- Connection limiting
- Security headers
- Hide server version

## Environment

Staging

## Status

- [*] Request rate limiting
- [*] Connection limiting
- [*] Security headers
- [*] Hide server version

### Verification

A stress test from an external client confirmed that Nginx rejected excess requests before they reached the Laravel application. The rate limiter was validated using temporary, stricter limits in the staging environment. After verification, production values were restored.

### Connection Limiting

Limit the number of simultaneous client connections to reduce resource exhaustion and slow HTTP attacks.
