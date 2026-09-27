[![CI Orchestrator](https://github.com/xver-por-ver/php-app-core/actions/workflows/ci-orchestrator.yml/badge.svg?branch=main&event=push)](https://github.com/xver-por-ver/php-app-core/actions/workflows/ci-orchestrator.yml)

## Continuous Integration

This project uses GitHub Actions for continuous integration.

The main workflow is `.github/workflows/ci-orchestrator.yml`, which delegates application checks to the reusable workflow `.github/workflows/application-quality-assurance.yml`.

CI runs on pushes and pull requests targeting `main`, except for documentation-only changes, license updates, and changes under `translations/`.

The application quality workflow performs:

- Composer validation
- Dependency installation
- PHPUnit test suite execution with coverage output
- Psalm static analysis
