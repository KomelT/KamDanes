import EventDetailsKulturnik
import requests
from bs4 import BeautifulSoup

HOME_URL = "https://dogodki.kulturnik.si/"

def scrape_events():
    soup = BeautifulSoup(requests.get(HOME_URL).text, features="html.parser")
    events = soup.find_all('article')
    for element in events:
        event = EventDetailsKulturnik.EventDetailsKulturnik(element.prettify())
        event.extract_data()
        print(event.get_json())
        event.push_to_database()
        print("-----------------------------------")