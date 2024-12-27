import os
from dotenv import load_dotenv
import requests
from bs4 import BeautifulSoup

class EventDetailsVisitLjubljana:
    def __init__(self, url):
        self.id_user = 103 #Visit Ljubljana
        self.url = url
        self.soup = BeautifulSoup(requests.get(url).text, 'html.parser')
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
        self.type_of_event = 1 #Kulturni dogodek
        self.longitude = None
        self.latitude = None
    
    def extract_data(self):
        self.title = self.get_title()
        self.start_date, self.end_date, self.start_time, self.end_time = self.get_date_and_time()
        self.location = self.get_location()
        self.get_location_coordinates()
    
    def get_title(self):
        h1 = self.soup.find('h1', class_="h2 color-red text-uppercase")
        return h1.text.strip()

    def get_date_and_time(self):
        section = self.soup.find('section', class_="event-dates-iterations")
        time_elements = section.find('p', class_="color-red").text

        delimiter = ","

        if "ob" in time_elements:
            date, time = time_elements.split(" ob ")
            date = '-'.join(date.strip().split('. ')[::-1]).strip()
            return date, None, time, None

        temp = time_elements.split(delimiter)
        if len(temp) == 2:
            dates = temp[0]
            times = temp[1]
        else:
            dates = time_elements
            times = None

        start_date, end_date, start_time, end_time = None, None, None, None

        if dates:
            # Split the date range into start and end parts
            date_parts = dates.split(' - ')
            start_date_part = date_parts[0].strip()
            end_date_part = date_parts[1].strip() if len(date_parts) > 1 else None

            # Extract the year from the end date if available
            if end_date_part and len(start_date_part.split('. ')) == 2:
                end_date_year = end_date_part.split('. ')[-1]
                start_date_part += f'{end_date_year}'

            # Format start and end dates to YYYY-MM-DD
            start_date = '-'.join(start_date_part.split('. ')[::-1]).strip()
            if end_date_part:
                end_date = '-'.join(end_date_part.split('. ')[::-1]).strip()

        if times:
            start_time = times.split('-')[0].strip()
            end_time = times.split('-')[1].strip()

        return start_date, end_date, start_time, end_time
    
    def get_location(self):
        section = self.soup.find('section', class_="event-dates-iterations")
        return section.find('p', class_=None).text.strip()

    def get_location_coordinates(self):
        load_dotenv()
        api_key = os.getenv('GoogleMapsKey')
        url = f'https://maps.googleapis.com/maps/api/geocode/json?address={self.location}&key={api_key}'
        
        response = requests.get(url)
        resp_json_payload = response.json()
        try:
            self.longitude = resp_json_payload['results'][0]['geometry']['location']['lng']
            self.latitude = resp_json_payload['results'][0]['geometry']['location']['lat']
        except:
            pass

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
        import json
        data = self.get_json()
        uri = 'http://localhost:3000/API/pushEvent'

        response = requests.post(uri, headers={'Content-Type': 'application/json'}, data=data)
    
    def get_json(self):
        import json
        data = {
            'id_user' : 103, #VisitLjubljana
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
    
