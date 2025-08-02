# Tech Test: Web scraper

## Requirements:
- [ ] Scrape the frontpage of a non-paywalled news site (e.g. news.com.au)
- [ ] Create tables/pie charts/bar graphs/line graphs showing trends and keywords
- [ ] Present a table with headlines and articles summary
- [x] No frameworks for the frontend or backend
- [x] Vanilla JS, bootstrap, JQuery are acceptable for the frontend.
- [x] JS libraries are also fine.
- [x] PHP for the backend only.
- [x] PHP to use API style response to JS fetch requests.
- [x] PHP using either functional/procedural style programming or OOP.

## My implementation

- build a php script to scrape and json the data from news.com.au
  - serialise to json in fileformat
- build api to emit json file as "api" call
- build front-end to visualise data
- use tailwind for styling

## Running the scraper

You can call the scraper via the terminal as

```bash
./scrape
```

## Project Structure

```
.
├── src/
├── tests/
├── public/
├── docker-compose.yml
├── Dockerfile
├── Makefile
├── composer.json
├── phpunit.xml
└── README.md
```

## Requirements

- Docker
- Make

## Getting Started

1. Clone the repository or download the project files.
2. Navigate to the project directory:

   ```bash
   cd project
   ```

3. Start the application using the Makefile:

   ```bash
   make serve
   ```

4. Install Composer dependencies inside the container:

   ```bash
   make init
   ```

5. Access the application in your web browser at [http://localhost:8000](http://localhost:8000).

## Stopping the Application

To stop the running containers, use:

```bash
make stop
```

## Entering the Workspace

The workspace allows you to access the required binaries/scripts for this project without any
additional requirements from the host (composer, etc)

To open a shell inside the running PHP container:

```bash
make workspace
```

## Initializing the Application

To install Composer dependencies (run after first setup or when dependencies change):

```bash
make init
```

This command will run `composer install` inside the PHP container, ensuring all PHP dependencies are installed according to `composer.json`. Use this after cloning the repository or whenever dependencies are updated.

## Running the Linter

To check code style using PHP_CodeSniffer (PSR-12):

```bash
make workspace
# Then inside the container:
composer lint
```

This will scan the `src` and `tests` directories for code style issues based on the PSR-12 standard.

## Running Tests

To run the test suite with PHPUnit:

```bash
make workspace
# Then inside the container:
composer test
```

To run tests with code coverage and enforce 100% coverage:

```bash
make workspace
# Then inside the container:
composer test:coverage
```

Test results and coverage reports will be available in the `build/` directory.
