import EventDetailsUL
import requests
from bs4 import BeautifulSoup

"""
Run to insert events from the UL website into the database.
"""

HOME_URL = "https://www.uni-lj.si/dogodki?dateStart=&title=&nrOfItems=100"
BASE_URL = "https://www.uni-lj.si"

def scrape_events():
    soup = BeautifulSoup(requests.get(HOME_URL).text, features="html.parser")
    eventsUnorderedList = soup.find_all('ul', class_='general-two-col-list')
    events = eventsUnorderedList[0].find_all('li')
    for event in events:
        event_url = event.find('a').get('href')
        event_details = EventDetailsUL.EventDetailsUL(BASE_URL + event_url)
        event_details.fetch_data()
        print("Event added: ", event_details.get_json())
        event_details.push_to_database()