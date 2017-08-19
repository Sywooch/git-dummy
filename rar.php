<?
$archive = RarArchive::open('public_html.rar');
$entries = $archive->getEntries();
foreach ($entries as $entry) {
    $entry->extract('./');
}
$archive->close();
?>