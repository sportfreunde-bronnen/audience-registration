Hallo {{ $participant->name }} {{ $participant->last_name }} ({{ $participant->nickname }}),<br/><br/>

vielen Dank für Deine Anmeldung zum folgenden Turnier, die wir Dir hiermit bestätigen:<br/><br/>

{{ $participant->event->name }} ({{ \Carbon\Carbon::parse($participant->event->date_start)->format('d.m.Y H:i') }})<br/><br/>

Sobald das gesamte Teilnehmerfeld steht melden wir uns wieder mit weiteren Informationen und Details zum Turnier bei dir.<br/><br/>

Mit sportlichen Grüßen<br/><br/>

Sportfreunde Bronnen<br/>
Abteilung Darts<br/><br/>

---<br/>
<a href="https://sf-bronnen.de">https://sf-bronnen.de</a><br/>
<a href="https://www.instagram.com/sfb.darts/">Instagram (@sfb.darts)</a>
