import EventDetailsUL
import requests
from bs4 import BeautifulSoup

HOME_URL = "https://www.uni-lj.si/dogodki?dateStart=&title=&nrOfItems=100"
BASE_URL = "https://www.uni-lj.si"

if __name__ == "__main__":
    soup = BeautifulSoup(requests.get(HOME_URL).text, features="html.parser")
    eventsUnorderedList = soup.find_all('ul', class_='general-two-col-list')
    events = eventsUnorderedList[0].find_all('li')
    for event in events:
        event_url = event.find('a').get('href')
        event_details = EventDetailsUL.EventDetailsUL(BASE_URL + event_url)
        event_details.fetch_data()
        event_details.print_event_details()
        print("-----------------------------------")