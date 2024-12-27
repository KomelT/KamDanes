import requests
from bs4 import BeautifulSoup
import EventDetailsVisitLjubljana

HOME_URL = 'https://www.visitljubljana.com/sl/obiskovalci/prireditve/prireditve-v-ljubljani/?cat=all&range=30&from=2024-12-27&to=9999-06-30'
BASE_URL = 'https://www.visitljubljana.com/'

soup = BeautifulSoup(requests.get(HOME_URL).text, features='html.parser')
ul = soup.find('ul', class_='general-list')
events = ul.find_all('li')
for element in events:
    event_url = element.find('a').get('href')
    event = EventDetailsVisitLjubljana.EventDetailsVisitLjubljana(BASE_URL + event_url)
    event.extract_data()
    print(event.get_json())
    event.push_to_database()
    print(",")
    