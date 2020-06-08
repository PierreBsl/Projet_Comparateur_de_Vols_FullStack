CREATE TABLE taxes (
    city VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    airportCode VARCHAR(255) NOT NULL,
    surcharge integer NOT NULL,
    PRIMARY KEY(airportCode)
);
INSERT INTO taxes (city, state, airportCode, surcharge) VALUES
( 'Bagotville', '  Que.', ' YBG ',  25 ),
( 'Baie-Comeau', '  Que.', ' YBC',  10 ),
( 'Bathurst', '  N.B.', ' ZBF',  40 ),
( 'Brandon', '  MB', ' YBR',  8.56 ),
( 'Calgary', '  Alta', ' YYC',  30 ),
( 'Castlegar', '  B.C.', ' YCG',  7 ),
( 'Charlo', '  N.B.', ' YCL',  40 );