import ScrapeEventsKulturnik
import ScrapeEventsUL
import ScrapeEventsVisitLjubljana
import threading

print(
    r"""
  _  __                 _____                           _____                                    
 | |/ /                |  __ \                         / ____|                                   
 | ' / __ _ _ __ ___   | |  | | __ _ _ __   ___  ___  | (___   ___ _ __ __ _ _ __   ___ _ __ ___ 
 |  < / _` | '_ ` _ \  | |  | |/ _` | '_ \ / _ \/ __|  \___ \ / __| '__/ _` | '_ \ / _ \ '__/ __|
 | . \ (_| | | | | | | | |__| | (_| | | | |  __/\__ \  ____) | (__| | | (_| | |_) |  __/ |  \__ \
 |_|\_\__,_|_| |_| |_| |_____/ \__,_|_| |_|\___||___/ |_____/ \___|_|  \__,_| .__/ \___|_|  |___/
                                                                            | |                  
                                                                            |_|                  
    """
)

def scrape_all_events():
  ScrapeEventsKulturnik.scrape_events()
  ScrapeEventsUL.scrape_events()
  ScrapeEventsVisitLjubljana.scrape_events()

def schedule_scraping():
  scrape_all_events()
  threading.Timer(86400, schedule_scraping).start()

schedule_scraping()