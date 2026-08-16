# Project Guidelines & Learnings — QDVisitorReception

Dit document bevat de richtlijnen, architectuurconventies en werkwijzen voor ontwikkelaars en AI-agents in deze repository.

---

## 1. UI & Design Systeem (Elementary OS)

### Kleurenschema ([elementary.io/brand](https://elementary.io/brand))
De gehele visuele stijl volgt de officiële Elementary OS kleurenpaletten:
- **Blueberry** (`#3689e6` / `#0d52bf`): Primaire accentkleur, actieve selecties, focusringen (`rgba(54, 137, 230, 0.28)`), en `.suggested-action`.
- **Strawberry** (`#c6262e` / `#ff8c82` / `#a10705`): Destructieve acties (o.a. uitchecken, verwijderen), foutmeldingen en `.destructive-action`.
- **Mint** (`#28bca3` / `#0e9a83` / `#007367`): Positieve bevestigingen, akkoord-knoppen en `.success-action`.
- **Orange & Banana** (`#f37329` / `#f9c440`): Waarschuwingen en accenten.
- **Slate** (`#0e141f`, `#273445`, `#485a6c`, `#667885`, `#95a3ab`): Donkere thema-achtergronden, teksten, HeaderBars en numpads.
- **Silver** (`#fafafa`, `#d4d4d4`, `#abacae`): Lichte achtergronden, kaarten en subtiele randen.

### Human Interface Guidelines ([docs.elementary.io/hig](https://docs.elementary.io/hig))
- **Typografie**: Gebruik van het lettertype **Inter** met **Title Case** voor alle koppen, veldlabels en actieknoppen.
- **WelcomeView**: Het startscherm gebruikt het WelcomeView-patroon met een hero-icoon, duidelijke welkomsttekst en prominente actietegels (`.welcome-tile`).
- **HeaderBar**: Elk scherm heeft een herkenbare HeaderBar (`.headerbar`) met titel, live klok, terugknop en/of taalkeuzeschakelaar.
- **Linked Mode Switchers**: Aaneengesloten pillenknoppen (`.linked-buttons` / `.lang-selector`) voor taalkeuze en gesegmenteerde bediening.
- **Entries**: Invoervelden hebben een border-radius van 8px, een duidelijke placeholder en een Blueberry focus-ring.
- **Cards & Dialogen**: Granite-stijl dialoogvensters met subtiele 1px randen en afgeronde hoeken (10px–12px).
- **Semantische Actieknoppen**:
  - `.suggested-action`: Voor de aanbevolen volgende stap (blauw).
  - `.success-action`: Voor positieve acceptatie/bevestiging (groen).
  - `.destructive-action`: Voor het beëindigen van een sessie of verwijderen (rood).

---

## 2. Containeromgeving (Podman)

- **Podman in plaats van Docker**: Op deze machine wordt **Podman** gebruikt (`podman`, `podman compose`). Gebruik nooit Docker CLI-commando's direct.
- **Containers opnieuw bouwen bij wijzigingen**: Omdat broncode en statische assets (`public/`, `configuration.php`) tijdens de build in de image worden gekopieerd via de `Dockerfile`, moeten de containers na wijzigingen opnieuw worden gebouwd en herstart:
  ```bash
  podman compose build --no-cache && podman compose up -d
  ```

---

## 3. Testen, Linting & Validatie

- **Uitvoeren in de container**: Tests, PHP syntax checks (`php -l`) en static analysis (Psalm/PHPStan) moeten worden uitgevoerd binnen de actieve Podman-container (`qdvisitorreception-php-1`):
  ```bash
  # Syntax check van alle PHP-bestanden
  podman exec qdvisitorreception-php-1 bash -c 'for f in $(find /var/www/html -name "*.php"); do php -l "$f"; done'
  ```
- **Live verificatie**: Controleer HTTP-statuscodes en responsen via:
  ```bash
  curl -sI http://localhost:8080/
  curl -sI http://localhost:8080/reception/
  ```
