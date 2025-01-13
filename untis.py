# -*- coding: utf-8 -*-


import webuntis
import sys
import json
from datetime import date
import traceback  # Zum Auslesen der detaillierten Fehlerbeschreibung

# Eingabedaten auslesen
input_data = sys.argv[1]  # Das Datenargument aus der Kommandozeile

try:
    # Wandelt den übergebenen String in ein Python-Objekt (Liste oder Dictionary) um
    input_dict = json.loads(input_data)
    
    # Verarbeite die Eingabedaten und füge eine Antwort hinzu
    username = input_dict.get("username")
    password = input_dict.get("password")
    server = input_dict.get("server")
    school = input_dict.get("school")
    
    # WebUntis-Session konfigurieren
    s = webuntis.Session(
        username=username,          
        password=password,             
        server=server,        
        school=school,           
        useragent='MannesmannGymnasium Script'
    )

    # Login
    s.login()

    # Beispiel: Stundenplan abrufen
    timetable = s.my_timetable(
        start=date(2025, 1, 7),
        end=date(2025, 1, 7)
    )

    # Umwandlung des Stundenplans in ein JSON-kompatibles Format
    def convert_period_list_to_json(period_list):
        timetable_serialized = []
        for entry in period_list:
            if not entry:
                continue
            period_data = {
                "start": int(entry.start.timestamp()) if entry.start else None,
                "end": int(entry.end.timestamp()) if entry.end else None,
                "subject": entry.subjects[0].name if entry.subjects else None,
                "code": entry.code if entry.code else None,
                "room": entry.rooms[0].name if entry.rooms else None,
                "type": entry.type if entry.type else None
            }
            timetable_serialized.append(period_data)

        return timetable_serialized

    timetable_serialized = convert_period_list_to_json(timetable)
    
    response = {
        "status": "success",
        "timetable": timetable_serialized
    }

    print(json.dumps(response))

except json.JSONDecodeError as e:
    # Fehlerbehandlung für ungültige JSON-Daten
    error_message = {
        "error": f"Ungültige JSON-Daten: {str(e)}",
        "exception": traceback.format_exc()  # Detaillierte Fehlerbeschreibung
    }
    print(json.dumps(error_message))

except webuntis.errors.RemoteError as e:
    # Fehlerbehandlung bei WebUntis RemoteError
    error_message = {
        "error": f"WebUntis-Fehler: {str(e)}",
        "exception": traceback.format_exc()  # Detaillierte Fehlerbeschreibung
    }
    print(json.dumps(error_message))

except Exception as e:
    # Allgemeine Fehlerbehandlung
    error_message = {
        "error": "Ungültige JSON-Daten: {}".format(str(e)),
        "exception": traceback.format_exc()  # Detaillierte Fehlerbeschreibung
    }
    print(json.dumps(error_message))

finally:
    sys.stdout.flush()
    if 's' in locals():
        s.logout()
