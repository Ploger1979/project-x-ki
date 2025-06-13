<?php

namespace App\Exceptions;

use Exception;

/**
 * Klasse ApiException
 *
 * Diese Exception-Klasse dient zur einheitlichen Behandlung von API-Fehlern.
 * Sie stellt sicher, dass API-bezogene Fehler im gesamten Code klar und konsistent
 * behandelt werden. Diese Struktur entspricht dem **PSR-1/PSR-12**-Standard.
 *
 * Qualitätsrichtlinien:
 * - **Zentralisierung** der API-Fehler für leichtere Wartbarkeit und Anpassbarkeit.
 * - **Modularität und Trennung**: Diese Klasse ist spezifisch für API-Fehler und vermeidet Vermischung.
 *
 * @package App\Exceptions
 */
class ApiException extends Exception
{
    // Erweiterungen oder spezielle Fehlerlogik könnten hier hinzugefügt werden.
}
