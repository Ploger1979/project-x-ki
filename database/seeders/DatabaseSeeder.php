<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin & Test Users
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Exact Kunden from Screenshot 3
        $kundenNames = [
            ['name' => 'Laura Schneider', 'email' => 'laura.schneider@gmail.com'],
            ['name' => 'Maximilian Wagner', 'email' => 'max.wagner@yahoo.de'],
            ['name' => 'Julia Weber', 'email' => 'julia.weber@outlook.com'],
            ['name' => 'Lukas Hoffmann', 'email' => 'lukas.hoffmann@web.de'],
            ['name' => 'Hannah Schulz', 'email' => 'hannah.schulz@gmail.com'],
            ['name' => 'Paul Neumann', 'email' => 'paul.neumann@gmx.de'],
            ['name' => 'Anna Zimmermann', 'email' => 'anna.zimmermann@t-online.de'],
            ['name' => 'Felix Lehmann', 'email' => 'felix.lehmann@gmail.com'],
            ['name' => 'Mia König', 'email' => 'mia.koenig@outlook.de'],
            ['name' => 'Tim Becker', 'email' => 'tim.becker@arcor.de'],
            ['name' => 'Sophie Braun', 'email' => 'sophie.braun@yahoo.de'],
            ['name' => 'Leon Fischer', 'email' => 'leon.fischer@web.de'],
            ['name' => 'Simon Lorenz', 'email' => 'simon.lorenz@gmx.de'],
            ['name' => 'Marie Günther', 'email' => 'marie.guenther@web.de'],
            ['name' => 'Ben Richter', 'email' => 'ben.richter@gmail.com'],
        ];

        \App\Models\Ticket::truncate();
        \App\Models\Kunde::truncate();

        $kundenMap = [];
        foreach ($kundenNames as $k) {
            $created = \App\Models\Kunde::create($k);
            $kundenMap[$k['name']] = $created->id;
        }

        // 3. Exact 20 Tickets matching Screenshot 2 (Total: 20, Offen: 9, In Bearbeitung: 0, Geschlossen: 11)
        $tickets = [
            // Closed tickets (#1 to #11)
            [
                'title' => 'Drucker im Erdgeschoss offline',
                'description' => 'Der Netzwerkdrucker im EG reagiert nicht auf Druckaufträge.',
                'status' => 'geschlossen',
                'date' => '2025-06-01',
                'time' => '08:30:00',
                'customer_id' => $kundenMap['Maximilian Wagner'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Niedrig**\n\nNetzwerkverbindung am Switch überprüft und Drucker neu gestartet.\n\n**Lösungsvorschlag:**\n1. IP-Zuweisung im DHCP erneuert.\n2. Testseite erfolgreich gedruckt."
            ],
            [
                'title' => 'Drucker streikt',
                'description' => 'Drucker im 3. Stock druckt nur leere Seiten.',
                'status' => 'geschlossen',
                'date' => '2025-06-02',
                'time' => '10:15:00',
                'customer_id' => $kundenMap['Julia Weber'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Mittel**\n\nDer Toner des Druckers ist leer oder der Druckkopf ist blockiert.\n\n**Lösungsvorschlag:**\n1. Tonerkartusche überprüfen und ersetzen.\n2. Testdruck über Wartungsmenü durchführen."
            ],
            [
                'title' => 'Login-Fehler',
                'description' => 'Mitarbeiter kann sich nicht mehr im System anmelden.',
                'status' => 'geschlossen',
                'date' => '2025-06-03',
                'time' => '09:00:00',
                'customer_id' => $kundenMap['Lukas Hoffmann'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Hoch**\n\nEin Mitarbeiter, der sich nicht im System anmelden kann, kann seine Arbeit nicht erledigen, was unmittelbar die Produktivität beeinflusst und wichtige Geschäftsprozesse blockiert.\n\n**Lösungsvorschlag:**\n1. Überprüfung der Anmeldeinformationen (Benutzername & Passwort).\n2. Zurücksetzen des Passworts über die Administrationskonsole.\n3. Überprüfung des Kontostatus im Active Directory (Konto gesperrt?)."
            ],
            [
                'title' => 'VPN-Verbindung bricht ab',
                'description' => 'Im Homeoffice trennt sich die VPN-Verbindung alle 15 Minuten.',
                'status' => 'geschlossen',
                'date' => '2025-06-04',
                'time' => '11:20:00',
                'customer_id' => $kundenMap['Hannah Schulz'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Mittel**\n\nKeepalive-Timeout in der OpenVPN-Konfiguration angepasst."
            ],
            [
                'title' => 'Softwarelizenz für Photoshop abgelaufen',
                'description' => 'Grafikabteilung benötigt Verlängerung der Adobe Cloud Lizenz.',
                'status' => 'geschlossen',
                'date' => '2025-06-04',
                'time' => '14:45:00',
                'customer_id' => $kundenMap['Paul Neumann'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Niedrig**\n\nLizenzschlüssel über das Firmenportal zugewiesen."
            ],
            [
                'title' => 'Zweiter Monitor flackert',
                'description' => 'Der externe HDMI-Monitor flackert unregelmäßig.',
                'status' => 'geschlossen',
                'date' => '2025-06-05',
                'time' => '13:10:00',
                'customer_id' => $kundenMap['Anna Zimmermann'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Niedrig**\n\nHDMI-Kabel ausgetauscht und Grafikkartentreiber aktualisiert."
            ],
            [
                'title' => 'Zugriff auf Netzlaufwerk Z: verweigert',
                'description' => 'Berechtigung für den Marketing-Ordner fehlt.',
                'status' => 'geschlossen',
                'date' => '2025-06-05',
                'time' => '15:30:00',
                'customer_id' => $kundenMap['Felix Lehmann'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Mittel**\n\nSicherheitsgruppe im Active Directory zugewiesen."
            ],
            [
                'title' => 'Outlook stürzt beim Start ab',
                'description' => 'Nach dem Windows-Update startet Outlook nicht mehr.',
                'status' => 'geschlossen',
                'date' => '2025-06-06',
                'time' => '08:45:00',
                'customer_id' => $kundenMap['Mia König'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Hoch**\n\nOutlook im abgesicherten Modus gestartet und fehlerhaftes Add-In deaktiviert."
            ],
            [
                'title' => 'Neuer Laptop für Praktikanten vorbereiten',
                'description' => 'Standard-Setup mit Windows 11 und Office 365 installieren.',
                'status' => 'geschlossen',
                'date' => '2025-06-06',
                'time' => '12:00:00',
                'customer_id' => $kundenMap['Tim Becker'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Niedrig**\n\nGerät per Autopilot bereitgestellt und übergeben."
            ],
            [
                'title' => 'Teams Mikrofon funktioniert nicht',
                'description' => 'Das Headset wird in Microsoft Teams nicht als Audiogerät erkannt.',
                'status' => 'geschlossen',
                'date' => '2025-06-07',
                'time' => '09:15:00',
                'customer_id' => $kundenMap['Sophie Braun'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Niedrig**\n\nDatenschutzeinstellungen für Mikrofonzugriff aktiviert."
            ],
            [
                'title' => 'Festplattenspeicher auf Server 02 fast voll',
                'description' => 'Laufwerk D: hat weniger als 5% freien Speicherplatz.',
                'status' => 'geschlossen',
                'date' => '2025-06-07',
                'time' => '16:00:00',
                'customer_id' => $kundenMap['Maximilian Wagner'] ?? null,
                'ai_response' => "**Bewertung der Wichtigkeit: Hoch**\n\nAlte Log-Dateien archiviert und Speicherplatz freigegeben."
            ],

            // Open tickets (#12 to #20) matching Screenshot 2
            [
                'title' => 'Tastatur reagiert verzögert',
                'description' => 'Kabellose Tastatur hat Aussetzer bei der Eingabe.',
                'status' => 'offen',
                'date' => '2025-06-08',
                'time' => '09:00:00',
                'customer_id' => $kundenMap['Julia Weber'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'Browser-Cache leeren funktioniert nicht',
                'description' => 'Interne Webanwendung zeigt veraltete Daten an.',
                'status' => 'offen',
                'date' => '2025-06-08',
                'time' => '10:30:00',
                'customer_id' => $kundenMap['Hannah Schulz'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'Mauszeiger friert sporadisch ein',
                'description' => 'Bluetooth-Verbindung der Maus bricht regelmäßig ab.',
                'status' => 'offen',
                'date' => '2025-06-09',
                'time' => '11:15:00',
                'customer_id' => $kundenMap['Paul Neumann'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'Audioausgabe über HDMI stumm',
                'description' => 'Konferenzraum-Fernseher gibt keinen Ton über HDMI aus.',
                'status' => 'offen',
                'date' => '2025-06-09',
                'time' => '14:20:00',
                'customer_id' => $kundenMap['Anna Zimmermann'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'PC startet nicht',
                'description' => 'Rechner gibt beim Einschalten drei kurze Signaltöne und bleibt schwarz.',
                'status' => 'offen',
                'date' => '2025-06-10',
                'time' => '08:15:00',
                'customer_id' => $kundenMap['Leon Fischer'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'WLAN sehr schwach',
                'description' => 'Im Büro 204 bricht das Firmen-WLAN ständig ab.',
                'status' => 'offen',
                'date' => '2025-06-10',
                'time' => '10:00:00',
                'customer_id' => $kundenMap['Ben Richter'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'Monitor wird nicht erkannt',
                'description' => 'Dockingstation überträgt kein Signal an den DisplayPort-Monitor.',
                'status' => 'offen',
                'date' => '2025-06-11',
                'time' => '09:20:00',
                'customer_id' => $kundenMap['Marie Günther'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'E-Mail Postfach voll',
                'description' => 'Exchange-Postfach hat das Kontingent von 50GB erreicht.',
                'status' => 'offen',
                'date' => '2025-06-11',
                'time' => '11:40:00',
                'customer_id' => $kundenMap['Simon Lorenz'] ?? null,
                'ai_response' => null
            ],
            [
                'title' => 'Tablet reagiert nicht',
                'description' => 'iPad im Empfangsbereich reagiert nicht mehr auf Touch-Eingaben.',
                'status' => 'offen',
                'date' => '2025-06-12',
                'time' => '08:50:00',
                'customer_id' => $kundenMap['Laura Schneider'] ?? null,
                'ai_response' => null
            ],
        ];

        foreach ($tickets as $t) {
            \App\Models\Ticket::create($t);
        }
    }
}
