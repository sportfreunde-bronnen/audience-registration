Hallo {{ $participant->name }} {{ $participant->last_name }},<br/><br/>

vielen Dank für Deine Anmeldung zu folgender Veranstaltung:<br/><br/>

{{ $participant->event->name }} ({{ \Carbon\Carbon::parse($participant->event->date_start)->format('d.m.Y H:i') }})<br/><br/>

Im Anhang findest Du Deinen QR-Code, den Du zwingend zum Einlass benötigst!<br/><br/>

Eine Zusammenfassung Deiner Anmeldung findest Du <a href="{{ route('visit.index', ['secret' => $participant->secret]) }}">unter diesem Link</a>.<br/><br/>

Viele Grüße,<br/>
{{ config('app.mail_footer_text') }}<br/><br/>

---<br/>
Web: <a href="{{ config('app.mail_url') }}">{{ config('app.mail_url') }}</a><br/>
Mail: <a href="mailto:{{ config('app.mail_email') }}">{{ config('app.mail_email') }}</a>
