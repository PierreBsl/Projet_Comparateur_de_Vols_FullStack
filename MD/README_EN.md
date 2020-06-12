# Project CIR2 Group 10
Group members : Eloi ANSELMET, Pierre BOISLEVE, Hugo MERLE, Tristan ROUX.

# Project framework :
- 2019/2020 end-of-year project for the CIR training of the second class of ISEN Yncrea Ouest - Nantes site - Carquefou 44470
- Objective of the project: create / simulate an airline ticket reservation site
- Version of the tools used:
    - PhpStorm : 2019.3.2
    - PostgreSQL : 9.6
    - Apache2 : 2.4

# System architecture:
- Presence of a database grouping flights, cities, taxes, prices, orders and customers
- The project was fully developed in PHP and SQL for the server part and in HTML, CSS (Use of Bootstrap) and JS for the client part.

#List of features
- From the index page (flight search page):
    - Enter the parameters of your search
    - If the departure or arrival airport does not exist, return an error to the user
    - If there is no flight available for this route, return an error to the user
    - If the user registers more than 9 people, returns an error to the user
    - Finally, if all the parameters are correct, and there are flights, returns the user to the flight display page
- From the displayVol page (display page of search results):
    - Sort this list of flights in ascending or descending order.
    - Choose the maximum price to display using the slider.
    - See the flights available on the following and previous days using the arrows
    - Return to search page
    - Select a flight from the list in order to proceed to confirmation
- From the flight confirmation page (flight confirmation page chosen in the previous page)
    - Enter the surname, first name, email address, date of birth and number of hold baggage for each adult passenger
    - Enter the surname, first name, date of birth and number of hold baggage for each child passenger
    - Dynamic trip display on a map
    - Ability to return to the list of flights
    - Validate your choice with the validate button
- After confirming these choices:
    - Summary of the order person by person
    - Total ticket price and price for a child / adult
    - Possibility to confirm or cancel the order with 2 buttons
    - If the order is validated, it will go to the flight database and the user will be returned to the index with a validation message and he will receive a message in his mailbox
    - If the order is canceled, it will be destroyed in the database and the user will be returned to the index with a message canceling the order
- User menu:
    - The user can connect with his email address and his date of birth,
    - He will see all the orders he has made
    - The user can cancel his reservation and that of these children
- Administrator menu:
    - The administrator can see the list of all the flights that have been booked on the site, see the emails and the dates of birth of the users
    - The administrator can cancel any ticket