<?php
// Fails (exit 1) when line coverage in a Clover report is below the threshold.
// Usage: php scripts/check-coverage.php build/clover.xml 80

$cloverFile = $argv[1] ?? 'build/clover.xml';
$threshold = (float) ($argv[2] ?? 80);

if (!is_file($cloverFile)) {
    fwrite(STDERR, "Clover report not found: $cloverFile (run the coverage step first)\n");
    exit(2);
}

$xml = simplexml_load_file($cloverFile);
if ($xml === false) {
    fwrite(STDERR, "Invalid XML in Clover report: $cloverFile\n");
    exit(2);
}

// Project-level metrics: "statements" = executable lines, "coveredstatements" = executed ones.
$metrics = $xml->project->metrics;
$statements = (int) $metrics['statements'];
$covered = (int) $metrics['coveredstatements'];
$coverage = $statements === 0 ? 100.0 : 100 * $covered / $statements;

printf("Line coverage: %.2f%% (%d/%d), threshold: %.2f%%\n", $coverage, $covered, $statements, $threshold);

if ($coverage < $threshold) {
    fwrite(STDERR, "Coverage is below the threshold\n");
    exit(1);
}
