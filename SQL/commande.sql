CREATE TABLE commande (
                       id SERIAL NOT NULL,
                       idcommande INTEGER NOT NULL,
                       adult INTEGER NOT NULL,
                       mail VARCHAR(255),
                       birth VARCHAR(255),
                       depense NUMERIC(10, 1),
                       nom VARCHAR(255),
                       prenom VARCHAR(255),
                       idReservation VARCHAR(255),
                       PRIMARY KEY(id)
);