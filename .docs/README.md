# EET

## Content

- [Setup](#setup)
- [Configuration](#configuration)

## Setup

```bash
composer require contributte/eet
```

```yaml
extensions:
    eet: Contributte\EET\DI\EETExtension
    
eet:
  certificate:
    path: %appDir%/../eet.p12
    password: my-password
```

## Configuration

```yaml
eet:
  certificate:
    path: %appDir%/../eet.p12
    password: my-password
    
  dispatcher:
    service: production / playground
    validate: true / false
```
