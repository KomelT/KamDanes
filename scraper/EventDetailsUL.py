import requests
from bs4 import BeautifulSoup

class EventDetailsUL:
    def __init__(self, url):
        self.url = url
        self.soup = None
        self.title = None
        self.start_date = None
        self.start_time = None
        self.end_date = None
        self.end_time = None
        self.location = None
        self.description = None

    def fetch_data(self):
        response = requests.get(self.url)
        if response.status_code == 200:
            html_content = response.text
            self.soup = BeautifulSoup(html_content, features="html.parser")
            self.extract_details()

    def extract_details(self):
        if self.soup:
            self.start_date, self.start_time, self.end_date, self.end_time = self.get_date_and_time()
            self.location = self.get_location()
            self.title = self.get_title()
            self.description = self.get_description()

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
            return None
        location = p.find('span', class_=None)
        return location.text if location else None

    def get_title(self):
        title_tag = self.soup.find('h1', class_='font-size-xl')
        return title_tag.text.strip() if title_tag else "Title not found"

    def get_description(self):
        description_tag = self.soup.find('p', class_='font-size-s')
        return description_tag.text.strip() if description_tag else "Description not found"

    def print_event_details(self):
        print("Link:", self.url)
        print("Naslov:", self.title)
        print("Start date:", self.start_date)
        print("Start time:", self.start_time)
        print("End date:", self.end_date)
        print("End time:", self.end_time)
        print("Location:", self.location)
        print("Opis:", self.description)

    def getTypeOfEvent(self):
        description = self.get_description(self)
        
