CREATE TABLE companyPrices (
    route VARCHAR(255) NOT NULL,
    weFlights INTEGER NOT NULL,
    fareCode VARCHAR(255) NOT NULL,
    dateToDeparture INTEGER NOT NULL,
    fillingRate INTEGER NOT NULL,
    fare INTEGER NOT NULL
);


INSERT INTO companyPrices (route, weFlights, fareCode, dateToDeparture, fillingRate, fare) VALUES
( 'YAM-YSJ',  0, ' Q',  21,  40,  140 ),
( 'YAM-YSJ',  0, ' M',  10,  70,  182 ),
( 'YAM-YSJ',  0, ' B',  3,  90,  326 ),
( 'YAM-YSJ',  0, ' Y',  0,  100,  543 ),
( 'YAM-YSJ',  1, ' Q',  21,  40,  171 ),
( 'YAM-YSJ',  1, ' M',  10,  70,  209 ),
( 'YAM-YSJ',  1, ' B',  3,  90,  391 ),
( 'YAM-YSJ',  1, ' Y',  0,  100,  619 ),
( 'YAM-YUL',  0, ' Q',  21,  40,  75 ),
( 'YAM-YUL',  0, ' M',  10,  70,  123 ),
( 'YAM-YUL',  0, ' B',  3,  90,  183 );