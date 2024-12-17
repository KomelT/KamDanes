import requests
from bs4 import BeautifulSoup

class EventDetailsUL:
    """
    A class to represent and scrape event details from a given URL.
    Attributes
    ----------
    url : str
        The URL of the event page.
    soup : BeautifulSoup object
        The parsed HTML content of the event page.
    title : str
        The title of the event.
    organisation : str
        The organisation hosting the event, default is "Univerza v Ljubljani".
    start_date : str
        The start date of the event.
    start_time : str
        The start time of the event.
    end_date : str
        The end date of the event.
    end_time : str
        The end time of the event.
    location : str
        The location of the event.
    age_limit : int
        The age limit for the event.
    price : int
        The price of the event, default is 0.
    description : str
        The description of the event.
    online : bool
        Indicates if the event is online, default is False.
    type_of_event : int
        The type of event, default is 0 (Univerzitetni dogodek).
    longitude : float
        The longitude of the event location.
    latitude : float
        The latitude of the event location.
    Methods
    -------
    fetch_data():
        Fetches the HTML content from the URL and parses it.
    extract_details():
        Extracts event details from the parsed HTML content.
    get_date_and_time():
        Retrieves the start and end date and time of the event.
    get_location():
        Retrieves the location of the event.
    get_title():
        Retrieves the title of the event.
    get_description():
        Retrieves the description of the event.
    print_event_details():
        Prints the event details.
    getTypeOfEvent():
        Placeholder method for getting the type of event.
    isOnlineEvent(description):
        Determines if the event is online based on keywords in the description.
    get_location_coordinates():
        Retrieves the geographical coordinates of the event location.
    push_to_database():
        Pushes the event details to a database.
    convert_time():
        Converts the event time to the local timezone.
    """
    def __init__(self, url):
        self.url = url
        self.soup = None
        self.title = None
        self.organisation = "Univerza v Ljubljani"
        self.start_date = None
        self.start_time = None
        self.end_date = None
        self.end_time = None
        self.location = None
        self.age_limit = None
        self.price = 0
        self.description = None
        self.online = False
        self.type_of_event = 0 #Univerzitetni dogodek
        self.longitude = None
        self.latitude = None

    def fetch_data(self):
        response = requests.get(self.url)
        if response.status_code == 200:
            html_content = response.text
            self.soup = BeautifulSoup(html_content, features="html.parser")
            self.extract_details()

    def extract_details(self):
        if self.soup:
            self.start_date, self.start_time, self.end_date, self.end_time = self.get_date_and_time()
            self.convert_time()
            self.location = self.get_location()
            self.title = self.get_title()
            self.description = self.get_description()
            self.get_location_coordinates()

    # Returns start date, start time, end date, end time in that order. If not returns None
    
    def get_date_and_time(self):
        time_wrapper = self.soup.find('p', class_='event-info-col-right font-size-xxs event-date-wrapper')
        if not time_wrapper:
            return [], [], [], []

        time_elements = time_wrapper.find_all('time')
        datetime_values = [el.get('datetime') for el in time_elements if el.has_attr('datetime')]
        if len(datetime_values) == 2:
            return datetime_values[0].split('T')[0], datetime_values[0].split('T')[1], datetime_values[1].split('T')[0], datetime_values[1].split('T')[1]
        elif len(datetime_values) == 1:
            return datetime_values[0].split('T')[0], datetime_values[0].split('T')[1], None, None
        else:
            return

    def get_location(self):
        p = self.soup.find('p', class_='event-info-col-right font-size-xxs')
        if not p:
            self.online = True
            return "Spletni dogodek"
        location = p.find('span', class_=None)
        if not location:
            self.online = True
            return "Spletni dogodek"
        if self.isOnlineEvent(location.text.strip()):
            self.online = True
            return "Spletni dogodek"
        else:
            return location.text.strip()

    def get_title(self):
        title_tag = self.soup.find('h1', class_='font-size-xl')
        return title_tag.text.strip() if title_tag else "Title not found"

    def get_description(self):
        description_tag = self.soup.find('p', class_='font-size-s')
        return description_tag.text.strip() if description_tag else "Description not found"

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

    def getTypeOfEvent(self):
        description = self.get_description(self)
    
    def isOnlineEvent(self, description):
        keywords = ['hibridno', 'online', 'spletni', 'zoom', 'stream', 'webinar', 'virtual', 'MS', 'Teams', 'Splet', 'spletno', 'Internet', 'virtualen', 'virtualno', 'Microsoft']
        for keyword in keywords:
            if keyword.lower() in description.lower():
                return True
        return False

    def get_location_coordinates(self):
        import os
        from dotenv import load_dotenv
        load_dotenv()
        clanice_kratice = ['AG', 'AGRFT', 'ALUO', 'BF', 'EF', 'FA', 'FDV', 'FE', 'FFA', 'FGG', 'FKKT', 'FMF', 'FPP', 'FRI', 'FSD', 'FS', 'FSP', 'FU', 'FF', 'MF', 'NTF', 'PEF', 'PF', 'TEOF', 'VF', 'ZF']
        clanice = [
        'Akademija za glasbo', 
        'Akademija za gledališče, radio, film in televizijo', 
        'Akademija za likovno umetnost in oblikovanje', 
        'Biotehniška fakulteta',
        'Ekonomska fakulteta',
        'Fakulteta za arhitekturo',
        'Fakulteta za družbene vede',
        'Fakulteta za elektrotehniko',
        'Fakulteta za farmacijo',
        'Fakulteta za gradbeništvo in geodezijo',
        'Fakulteta za kemijo in kemijsko tehnologijo',
        'Fakulteta za matematiko in fiziko',
        'Fakulteta za pomorstvo in promet',
        'Fakulteta za računalništvo in informatiko',
        'Fakulteta za socialno delo',
        'Fakulteta za strojništvo',
        'Fakulteta za šport',
        'Fakulteta za upravo',
        'Filozofska fakulteta',
        'Medicinska fakulteta',
        'Naravoslovnotehniška fakulteta',
        'Pedagoška fakulteta',
        'Pravna fakulteta',
        'Teološka fakulteta',
        'Veterinarska fakulteta',
        'Zdravstvena fakulteta'
        ]

        if self.location == "Spletni dogodek":
            return
        addresses = self.location.split(',')

        updated_address = ''

        for chunk in addresses:
            if chunk.strip().split(' ')[0] == 'UL' and chunk.strip().split(' ')[1] in clanice_kratice:
                updated_address += clanice[clanice_kratice.index(chunk.strip().split(' ')[1])] + ', '
            else:
                updated_address += chunk + ', '

        if updated_address:
            api_key = os.getenv('GoogleMapsKey')
            url = f'https://maps.googleapis.com/maps/api/geocode/json?address={updated_address}&key={api_key}'
            
            response = requests.get(url)
            resp_json_payload = response.json()

            # print(resp_json_payload['results'][0]['geometry']['location'])
            self.longitude = resp_json_payload['results'][0]['geometry']['location']['lng']
            self.latitude = resp_json_payload['results'][0]['geometry']['location']['lat']
    
    def push_to_database(self):
        import requests
        import json
        data = {
            'id_user' : 100, #UL
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

        uri = 'http://localhost:3000/API/pushEvent'

        response = requests.post(uri, headers={'Content-Type': 'application/json'}, data=json.dumps(data))
        

    def convert_time(self):
        from datetime import datetime
        import pytz

        local_tz = pytz.timezone('Europe/Berlin')  # Replace with your local timezone

        if(self.start_time):
            old_start_time = datetime.fromisoformat("2024-12-12T" + self.start_time)
            start_time_dt = old_start_time.astimezone(local_tz)
            new_start_time = start_time_dt.strftime("%Y-%m-%d %H:%M")
            self.start_time = new_start_time.split(" ")[1]

        if(self.end_time):
            old_end_time = datetime.fromisoformat("2024-12-12T" + self.end_time)
            end_time_dt = old_end_time.astimezone(local_tz)
            new_end_time = end_time_dt.strftime("%Y-%m-%d %H:%M")
            self.end_time = new_end_time.split(" ")[1]

