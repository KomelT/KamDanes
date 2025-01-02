import EventDetailsKulturnik
import requests
from bs4 import BeautifulSoup

HOME_URL = "https://dogodki.kulturnik.si/?what="
WHAT = [(1,"festivali"),(1,"film"),(2,"glasba"),(1,"gledalisce"),(3,"izobrazevanje"),(1,"tisk"),(6,"razstava"),(6,"otroci")]

def scrape_events():
    for (type,what) in WHAT:

        soup = BeautifulSoup(requests.get(HOME_URL+what).text, features="html.parser")
        events = soup.find_all('article')
        for element in events:
            event = EventDetailsKulturnik.EventDetailsKulturnik(element.prettify(),type)
            event.extract_data()
            print(event.get_json())
            event.push_to_database()
            print("-----------------------------------")