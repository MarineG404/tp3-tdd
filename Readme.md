# OrderFlow PHP (TDD, S3-TP1)

Calcul de la remise par palier (`src/remise.php`), testé avec PHPUnit.

## Prérequis

- PHP >= 8.3, Composer
- Xdebug pour la couverture (Fedora : `sudo dnf install php-pecl-xdebug3`). Pas besoin de toucher au `php.ini` : le script `coverage` active le mode avec `-d xdebug.mode=coverage`.

## Commandes

```bash
composer install          # préparation
composer test             # tests + rapport JUnit (build/junit.xml)
composer coverage         # tests + JUnit + TestDox HTML + couverture Clover/HTML
composer coverage-check   # échoue si couverture des lignes < 80 % (lit build/clover.xml)
composer audit            # audit de sécurité des dépendances
composer ci               # tout enchaîner : coverage, coverage-check, audit
```

## Rapports générés (`build/`, ignoré par git)

| Fichier                     | Contenu                                                           |
| --------------------------- | ----------------------------------------------------------------- |
| `build/junit.xml`           | Rapport JUnit XML (pour la CI, les outils)                        |
| `build/testdox.html`        | Liste des tests lisible (pour les humains)                        |
| `build/clover.xml`          | Couverture au format Clover (lu par `scripts/check-coverage.php`) |
| `build/coverage/index.html` | Rapport de couverture HTML                                        |

## CI

`.github/workflows/ci.yml` lance les mêmes étapes sur GitHub Actions à chaque push, et le dossier `build/` est conservé comme artefact `reports`.

| Étape            | Outil                                             |
| ---------------- | ------------------------------------------------- |
| Préparation      | `shivammathur/setup-php` (PHP 8.4, `coverage: xdebug`) |
| Tests + JUnit    | `composer coverage` (`phpunit --log-junit`)        |
| Seuil couverture | `composer coverage-check` (script Clover, 80 %)    |
| Audit            | `composer audit`                                  |
