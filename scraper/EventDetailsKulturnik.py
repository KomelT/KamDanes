import os
from dotenv import load_dotenv
import requests
from bs4 import BeautifulSoup

class EventDetailsKulturnik:
    def __init__(self, event,type):
        self.id_user = 101
        self.url = None
        self.soup = BeautifulSoup(event, 'html.parser')
        self.title = None
        self.organisation = None
        self.start_date = None
        self.start_time = None
        self.end_date = None
        self.end_time = None
        self.location = None
        self.age_limit = None
        self.price = None
        self.description = None
        self.online = False
        self.type_of_event = type #type je odvisen na kater url scrapa
        self.longitude = None
        self.latitude = None

    def extract_data(self):
        self.url = self.get_url()
        self.title = self.get_title()
        self.start_date, self.start_time, self.end_date, self.end_time = self.get_date_and_time()
        self.convert_time()
        self.location = self.get_location()
        self.get_location_coordinates()

    def get_title(self):
        h2 = self.soup.find('h2')
        if h2.find('a'):
            return h2.find('a').text.strip()
        else:
            return h2.text.strip()
    
    def get_date_and_time(self):
        time_elements = self.soup.find_all('time')
        if not time_elements:
            return None, None, None, None
        if len(time_elements) == 1:
            return time_elements[0].text.split('T')[0].strip(), time_elements[0].text.split('T')[1].strip(), None, None
        elif len(time_elements) == 2:
            return time_elements[0].text.split('T')[0].strip(), time_elements[0].text.split('T')[1].strip(), time_elements[1].text.split('T')[0].strip(), time_elements[1].text.split('T')[1].strip()
        
    def convert_time(self):
        from datetime import datetime
        import pytz

        local_tz = pytz.timezone('Europe/Berlin')  

        if(self.start_time):
            old_start_time = datetime.fromisoformat("2024-12-12T" + self.start_time.strip())
            start_time_dt = old_start_time.astimezone(local_tz)
            new_start_time = start_time_dt.strftime("%Y-%m-%d %H:%M")
            self.start_time = new_start_time.split(" ")[1]

        if(self.end_time):
            old_end_time = datetime.fromisoformat("2024-12-12T" + self.end_time.strip())
            end_time_dt = old_end_time.astimezone(local_tz)
            new_end_time = end_time_dt.strftime("%Y-%m-%d %H:%M")
            self.end_time = new_end_time.split(" ")[1]
    
    def get_location(self):
        div_location = self.soup.find('div', class_='info location')
        locations = div_location.find_all('a')

        location = ''

        for element in locations:
            location += element.text.strip() + ", "
        
        return location[:-2].strip()
    
    def get_location_coordinates(self):
        load_dotenv()
        api_key = os.getenv('GoogleMapsKey')
        url = f'https://maps.googleapis.com/maps/api/geocode/json?address={self.location}&key={api_key}'
        
        response = requests.get(url)
        resp_json_payload = response.json()
        if len(resp_json_payload['results']) > 0:
            self.longitude = resp_json_payload['results'][0]['geometry']['location']['lng']
            self.latitude = resp_json_payload['results'][0]['geometry']['location']['lat']
    
    def get_url(self):
        h2 = self.soup.find('h2', class_=['item-title', 'summary'])
        if h2:
            a = h2.find('a')
            if a:
                return a.get('href').strip()
        return None

    def print_event_details(self):
        print("Link:", self.url)
        print("Naslov:", self.title)
        print("Organizacija:", self.organisation)
        print("Start date:", self.start_date)
        print("Start time:", self.start_time)
        print("End date:", self.end_date)
        print("End time:", self.end_time)
        print("Price:", self.price)
        print("Age limit:", self.age_limit)
        print("Location:", self.location)
        print("Opis:", self.description)
        print("Online:", self.online)
        print("Longitude:", self.longitude)
        print("Latitude:", self.latitude)
    
    def push_to_database(self):
        import requests
        import os
        
        app_url = os.getenv('APP_URL', 'http://localhost:3000')
        
        data = self.get_json()
        uri = f'{app_url}/API/pushEvent'

        response = requests.post(uri, headers={'Content-Type': 'application/json'}, data=data)
    
    def get_json(self):
        import json
        data = {
            'id_user' : 101, #Kulturnik
            'name' : self.title if self.title else None,
            'organisation' : self.organisation if self.organisation else None,
            'artist_name' : None,
            'date_from' : self.start_date if self.start_date else None,
            'date_to' : self.end_date if self.end_date else None,
            'loc_x' : self.longitude if self.longitude else None,
            'loc_y' : self.latitude if self.latitude else None,
            'time_from' :self.start_time if self.start_time else None,
            'time_to' : self.end_time if self.end_time else self.start_time,
            'age_lim' : self.age_limit if self.age_limit else None,
            'description' : self.description if self.description else None,
            'price' : self.price if self.price else None,
            'type' : self.type_of_event if self.type_of_event else 0,
            'link' : self.url if self.url else None,
            'online' : 1 if self.location == "Spletni dogodek" else 0
        }

        return json.dumps(data)
    
