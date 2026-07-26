# Observability & Monitoring

## Objective

Provide real-time monitoring, visualization, and operational awareness for the CMMS infrastructure.

## Components

- Grafana
- Prometheus
- Node Exporter
- cAdvisor
- Watchtower

## Status

- [x] Deploy Node Exporter
- [x] Deploy Prometheus
- [x] Configure Prometheus targets
- [x] Add Prometheus datasource to Grafana
- [x] Import Node Exporter dashboard
- [x] Deploy cAdvisor
- [x] Deploy Watchtower (monitor-only)
- [x] Verify image update scanning

## TODO

- [ ] Configure Grafana alerting
- [ ] Build CMMS Operations dashboard
- [ ] Monitor Docker container health
- [ ] Add email/Telegram notifications
- [ ] Monitor SSL certificate expiration
- [ ] Monitor backup status
