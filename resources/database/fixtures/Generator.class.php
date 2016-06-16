<?php
namespace Fixtures;

class Generator
{
    private $filename;
    private $sql = array();

    public function __construct($output)
    {
        $this->filename = $output;
        mt_srand($this->makeSeed());
        date_default_timezone_set('UTC');
    }

    private function makeSeed()
    {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }

    /**
     * @param string $table
     */
    private function addStatement($table, $data)
    {
        if (!array_key_exists($table, $this->sql)) {
            $this->sql[$table] = array(
                'data' => array(),
                'query' => array(),
            );
        }

        $this->sql[$table]['data'][] = $data;

        if (is_array($data)) {
            $sql = array(
                'columns' => array(),
                'values' => array(),
            );
            foreach ($data as $column => $value) {
                $sql['columns'][] = $column;
                if (is_string($value)) {
                    $sql['values'][] = '\'' . $value . '\'';
                    continue;
                }
                if (is_null($value)) {
                    $sql['values'][] = 'null';
                    continue;
                }
                $sql['values'][] = $value;
            }

            $sql['columns'] = implode(', ', $sql['columns']);
            $sql['values'] = implode(', ', $sql['values']);

            $this->sql[$table]['query'][] =
                'INSERT INTO "neap"."' . $table . '"(' .
                $sql['columns'] .
                ') VALUES (' .
                $sql['values'] .
                ');';

            return;
        }

        $this->sql[$table]['query'][] = $data;
    }

    private function writeFile()
    {
        file_put_contents($this->filename, implode(PHP_EOL, $this->sql['before']['query']) . PHP_EOL, LOCK_EX);
        foreach (array(
            'ingest',
            'outage',
            'topic',
            'user',
            'team',
            'member',
            'channel',
            'panel',
            'chat',
            'stream',
            'video',
            'favorite',
            'follow',
            'block',
            'mod'
        ) as $entity) {
            if (!array_key_exists($entity, $this->sql)) {
                continue;
            }

            file_put_contents(
                $this->filename,
                implode(PHP_EOL, $this->sql[$entity]['query']) . PHP_EOL,
                LOCK_EX | FILE_APPEND
            );
        }

        file_put_contents(
            $this->filename,
            implode(PHP_EOL, $this->sql['after']['query']) . PHP_EOL,
            LOCK_EX | FILE_APPEND
        );
    }

    public function generate()
    {
        // Prepare the SQL script by setting the workspace and initiating a transaction
        $this->addStatement('before', 'SET search_path TO pg_catalog, public, "neap";');
        $this->addStatement('before', 'BEGIN;');
        $this->addStatement('before', 'SET CONSTRAINTS ALL DEFERRED;');

        $dateConverter = new DateConverter();
        $uuid = new UUID();

        // Prepare some resource data
        $data = array();
        $data['topics'] = array(
            $uuid::generateV4() => 'Mathematics',
            $uuid::generateV4() => 'Science',
            $uuid::generateV4() => 'Astrology',
            $uuid::generateV4() => 'Litterature',
            $uuid::generateV4() => 'Biology',
            $uuid::generateV4() => 'History',
            $uuid::generateV4() => 'Theology',
            $uuid::generateV4() => 'Philosophy',
            $uuid::generateV4() => 'Music',
            $uuid::generateV4() => 'Photography',
            $uuid::generateV4() => 'Video games',
        );
        $data['teamNames'] = array(
            $uuid::generateV4() => 'Lonely Assailant',
            $uuid::generateV4() => 'Incredible Alliance',
            $uuid::generateV4() => 'Tasteful Almighty',
            $uuid::generateV4() => 'Inquisitive Discipline',
            $uuid::generateV4() => 'Peaceful Irresistible',
            $uuid::generateV4() => 'Earsplitting Rebels',
            $uuid::generateV4() => 'Envious Liquidators',
            $uuid::generateV4() => 'Encouraging Knights',
            $uuid::generateV4() => 'Zonked Exile',
            $uuid::generateV4() => 'Hollow Coercion',
            $uuid::generateV4() => 'Troubled Desperado',
            $uuid::generateV4() => 'Dead Assassins',
            $uuid::generateV4() => 'Royal Gangsters',
            $uuid::generateV4() => 'Parsimonious Voltiac',
            $uuid::generateV4() => 'Ajar Enemy',
            $uuid::generateV4() => 'Billowy Warfare',
            $uuid::generateV4() => 'Oval Gang',
            $uuid::generateV4() => 'Acidic Occupation',
            $uuid::generateV4() => 'Hilarious Outlaws',
            $uuid::generateV4() => 'Expensive Moguls',
            $uuid::generateV4() => 'Deafening Veterans',
            $uuid::generateV4() => 'Wealthy Deadly',
            $uuid::generateV4() => 'Hot Force',
            $uuid::generateV4() => 'Deserted Butchers',
            $uuid::generateV4() => 'Nondescript Sharpshooters',
            $uuid::generateV4() => 'Abundant Privilege',
            $uuid::generateV4() => 'Magical Thugs',
            $uuid::generateV4() => 'Able Power',
            $uuid::generateV4() => 'Honorable Criminals',
            $uuid::generateV4() => 'Inexpensive Vigor',
            $uuid::generateV4() => 'Rich Domination',
            $uuid::generateV4() => 'Useful Slayers',
            $uuid::generateV4() => 'Orange Devils',
            $uuid::generateV4() => 'Undesirable Tyranny',
            $uuid::generateV4() => 'Polite Hooligans',
            $uuid::generateV4() => 'Protective Punks',
            $uuid::generateV4() => 'Aquatic Strategy',
            $uuid::generateV4() => 'Future Squad',
            $uuid::generateV4() => 'Overwrought Exterminators',
            $uuid::generateV4() => 'Whimsical Prestige',
            $uuid::generateV4() => 'Dashing Admirals',
            $uuid::generateV4() => 'Periodic Perpetrator',
            $uuid::generateV4() => 'Maniacal Mafia',
            $uuid::generateV4() => 'Gruesome Soldiers',
            $uuid::generateV4() => 'Capable killers',
            $uuid::generateV4() => 'Sweltering Noobs',
            $uuid::generateV4() => 'Square Superpower',
            $uuid::generateV4() => 'Alluring Bureau',
            $uuid::generateV4() => 'Materialistic Delinquents',
            $uuid::generateV4() => 'Tacky Privilege',
            $uuid::generateV4() => 'Diligent Thugs',
            $uuid::generateV4() => 'Spiffy Power',
            $uuid::generateV4() => 'Lackadaisical Criminals',
            $uuid::generateV4() => 'Snotty Vigor',
            $uuid::generateV4() => 'Melodic Domination',
            $uuid::generateV4() => 'Tiny Slayers',
            $uuid::generateV4() => 'Messy Devils',
            $uuid::generateV4() => 'Different Tyranny',
            $uuid::generateV4() => 'Foregoing Hooligans',
            $uuid::generateV4() => 'Spiritual Punks'
        );
        $data['userNames'] = array('Noah', 'Liam', 'Mason', 'Jacob', 'William', 'Ethan', 'Michael', 'Alexander', 'James', 'Daniel', 'Elijah', 'Benjamin', 'Logan', 'Aiden', 'Jayden', 'Matthew', 'Jackson', 'David', 'Lucas', 'Joseph', 'Anthony', 'Andrew', 'Samuel', 'Gabriel', 'Joshua', 'John', 'Carter', 'Luke', 'Dylan', 'Christopher', 'Isaac', 'Oliver', 'Henry', 'Sebastian', 'Caleb', 'Owen', 'Ryan', 'Nathan', 'Wyatt', 'Hunter', 'Jack', 'Christian', 'Landon', 'Jonathan', 'Levi', 'Jaxon', 'Julian', 'Isaiah', 'Eli', 'Aaron', 'Charles', 'Connor', 'Cameron', 'Thomas', 'Jordan', 'Jeremiah', 'Nicholas', 'Evan', 'Adrian', 'Gavin', 'Robert', 'Brayden', 'Grayson', 'Josiah', 'Colton', 'Austin', 'Angel', 'Jace', 'Dominic', 'Kevin', 'Brandon', 'Tyler', 'Parker', 'Ayden', 'Jason', 'Jose', 'Ian', 'Chase', 'Adam', 'Hudson', 'Nolan', 'Zachary', 'Easton', 'Jaxson', 'Cooper', 'Lincoln', 'Xavier', 'Bentley', 'Kayden', 'Carson', 'Brody', 'Asher', 'Nathaniel', 'Ryder', 'Justin', 'Leo', 'Juan', 'Luis', 'Camden', 'Tristan', 'Damian', 'Elias', 'Vincent', 'Jase', 'Mateo', 'Maxwell', 'Miles', 'Micah', 'Sawyer', 'Jesus', 'Max', 'Roman', 'Leonardo', 'Santiago', 'Cole', 'Carlos', 'Bryson', 'Ezra', 'Brantley', 'Braxton', 'Declan', 'Eric', 'Kaiden', 'Giovanni', 'Theodore', 'Harrison', 'Alex', 'Diego', 'Wesley', 'Bryce', 'Ivan', 'Greyson', 'George', 'Timothy', 'Weston', 'Silas', 'Jonah', 'Antonio', 'Colin', 'Richard', 'Hayden', 'Ashton', 'Steven', 'Axel', 'Miguel', 'Kaleb', 'Bryan', 'Preston', 'Jayce', 'Ryker', 'Victor', 'Patrick', 'Joel', 'Grant', 'Emmett', 'Alejandro', 'Marcus', 'Jameson', 'Edward', 'Kingston', 'Jude', 'Maddox', 'Abel', 'Emmanuel', 'Bennett', 'Everett', 'Brian', 'Jeremy', 'Alan', 'Kaden', 'Jaden', 'Riley', 'Jesse', 'King', 'Tucker', 'Kai', 'Kyle', 'Malachi', 'Abraham', 'Ezekiel', 'Calvin', 'Oscar', 'Bradley', 'Luca', 'Avery', 'Aidan', 'Zayden', 'Mark', 'Jake', 'Kenneth', 'Maximus', 'Sean', 'Karter', 'Brady', 'Nicolas', 'Cayden', 'Caden', 'Graham', 'Jayceon', 'Paul', 'Gage', 'Corbin', 'Peter', 'Derek', 'Maverick', 'Jorge', 'Tanner', 'Jax', 'Peyton', 'Xander', 'Amir', 'Gael', 'Omar', 'Iker', 'Javier', 'Elliot', 'Jasper', 'Rylan', 'Cody', 'Dean', 'Andres', 'Collin', 'Zane', 'Charlie', 'Myles', 'Lorenzo', 'Beau', 'Conner', 'Lukas', 'Simon', 'Francisco', 'Elliott', 'Finn', 'Gunner', 'Garrett', 'Jaiden', 'Keegan', 'Rowan', 'Israel', 'Griffin', 'August', 'Judah', 'Beckett', 'Brooks', 'Zander', 'Spencer', 'Chance', 'Damien', 'Seth', 'Waylon', 'Travis', 'Devin', 'Emiliano', 'Zion', 'Ricardo', 'Erick', 'Stephen', 'Reid', 'Paxton', 'Eduardo', 'Martin', 'Fernando', 'Raymond', 'Manuel', 'Jeffrey', 'Felix', 'Dallas', 'Josue', 'Mario', 'Clayton', 'Caiden', 'Cristian', 'Troy', 'Cash', 'Trevor', 'Shane', 'Kameron', 'Cesar', 'Emilio', 'Andy', 'Tyson', 'Andre', 'Donovan', 'Titus', 'Knox', 'River', 'Kyler', 'Louis', 'Cruz', 'Hector', 'Holden', 'Rafael', 'Landen', 'Lane', 'Jared', 'Edwin', 'Messiah', 'Johnny', 'Edgar', 'Johnathan', 'Alexis', 'Archer', 'Anderson', 'Trenton', 'Arthur', 'Sergio', 'Marco', 'Julius', 'Dominick', 'Milo', 'Dalton', 'Remington', 'Dante', 'Angelo', 'Gregory', 'Reed', 'Jaylen', 'Marshall', 'Dawson', 'Leon', 'Drew', 'Shawn', 'Emerson', 'Fabian', 'Joaquin', 'Walker', 'Erik', 'Desmond', 'Karson', 'Emanuel', 'Jett', 'Ali', 'Kendrick', 'Aden', 'Frank', 'Walter', 'Rhett', 'Colt', 'Amari', 'Romeo', 'Cohen', 'Roberto', 'Maximiliano', 'Grady', 'Barrett', 'Zaiden', 'Drake', 'Gideon', 'Major', 'Brendan', 'Skyler', 'Derrick', 'Pedro', 'Phoenix', 'Noel', 'Ruben', 'Braden', 'Nehemiah', 'Dakota', 'Cade', 'Kamden', 'Quinn', 'Nash', 'Kason', 'Ronan', 'Allen', 'Porter', 'Enzo', 'Atticus', 'Kash', 'Jay', 'Adan', 'Finley', 'Matteo', 'Malik', 'Abram', 'Braylon', 'Ace', 'Solomon', 'Gunnar', 'Clark', 'Orion', 'Ismael', 'Kellan', 'Brennan', 'Corey', 'Tate', 'Philip', 'Thiago', 'Phillip', 'Esteban', 'Jayson', 'Dexter', 'Jensen', 'Pablo', 'Ronald', 'Dillon', 'Muhammad', 'Armando', 'Bruce', 'Gerardo', 'Brycen', 'Marcos', 'Kade', 'Kolton', 'Damon', 'Braylen', 'Russell', 'Leland', 'Milan', 'Prince', 'Gannon', 'Enrique', 'Keith', 'Rory', 'Brock', 'Donald', 'Tobias', 'Chandler', 'Deacon', 'Cason', 'Raul', 'Ty', 'Scott', 'Landyn', 'Mohamed', 'Colby', 'Danny', 'Leonel', 'Kayson', 'Warren', 'Adriel', 'Dustin', 'Taylor', 'Albert', 'Ryland', 'Hugo', 'Keaton', 'Jamison', 'Ari', 'Malcolm', 'Ellis', 'Kellen', 'Maximilian', 'Davis', 'Saul', 'Tony', 'Rocco', 'Zachariah', 'Jerry', 'Julio', 'Franklin', 'Arjun', 'Ibrahim', 'Nico', 'Jaxton', 'Jakob', 'Izaiah', 'Moises', 'Cyrus', 'Lawrence', 'Sullivan', 'Finnegan', 'Khalil', 'Mathew', 'Case', 'Jaime', 'Alec', 'Pierce', 'Quentin', 'Kasen', 'Darius', 'Colten', 'Royce', 'Odin', 'Kane', 'Francis', 'Raiden', 'Trey', 'Daxton', 'Gustavo', 'Rhys', 'Alijah', 'Lawson', 'Beckham', 'Moses', 'Rodrigo', 'Armani', 'Uriel', 'Dennis', 'Marvin', 'Harvey', 'Kian', 'Raylan', 'Darren', 'Frederick', 'Mohammed', 'Trent', 'Jonas', 'Zayne', 'Callen', 'Matias', 'Mitchell', 'Kyrie', 'Uriah', 'Tristen', 'Sterling', 'Theo', 'Larry', 'Randy', 'Korbin', 'Alberto', 'Chris', 'Gianni', 'Killian', 'Princeton', 'Arturo', 'Ricky', 'Malakai', 'Aarav', 'Asa', 'Jimmy', 'Alfredo', 'Alonzo', 'Benson', 'Braydon', 'Devon', 'Curtis', 'Casey', 'Justice', 'Roy', 'Sam', 'Legend', 'Dorian', 'Nikolai', 'Kobe', 'Winston', 'Arlo', 'Reece', 'Lance', 'Wade', 'Cannon', 'Augustus', 'Hayes', 'Hendrix', 'Isaias', 'Neymar', 'Ahmed', 'Jaxen', 'Nasir', 'Brayan', 'Issac', 'Ronin', 'Talon', 'Boston', 'Moshe', 'Orlando', 'Vihaan', 'Gary', 'Bowen', 'Luka', 'Nikolas', 'Yahir', 'Joe', 'Leonidas', 'Quinton', 'Luciano', 'Ezequiel', 'Ayaan', 'Ahmad', 'Jalen', 'Royal', 'Jamari', 'Noe', 'Kieran', 'Mauricio', 'Conor', 'Johan', 'Matthias', 'Bryant', 'Mathias', 'Maurice', 'Roger', 'Lennox', 'Nathanael', 'Nixon', 'Mohammad', 'Yusuf', 'Eddie', 'Kristopher', 'Tatum', 'Jacoby', 'Wilson', 'Alvin', 'Raphael', 'Lewis', 'Douglas', 'Mekhi', 'Salvador', 'Eden', 'Hank', 'Cullen', 'Dax', 'Toby', 'Rayan', 'Emmitt', 'Lucian', 'Jefferson', 'Casen', 'London', 'Roland', 'Carl', 'Crosby', 'Bodhi', 'Dominik', 'Niko', 'Zackary', 'Deandre', 'Hamza', 'Remy', 'Quincy', 'Alessandro', 'Sincere', 'Dane', 'Terry', 'Otto', 'Samson', 'Madden', 'Jasiah', 'Layne', 'Santino', 'Rohan', 'Abdullah', 'Brentley', 'Marc', 'Skylar', 'Bo', 'Kyson', 'Soren', 'Harley', 'Nelson', 'Layton', 'Payton', 'Aldo', 'Atlas', 'Ramon', 'Reese', 'Conrad', 'Morgan', 'Ernesto', 'Byron', 'Carmelo', 'Sage', 'Neil', 'Kristian', 'Oakley', 'Tomas', 'Flynn', 'Lionel', 'Kylan', 'Leonard', 'Rex', 'Brett', 'Jeffery', 'Duke', 'Sylas', 'Callan', 'Tripp', 'Bruno', 'Zechariah', 'Melvin', 'Branson', 'Blaine', 'Jon', 'Julien', 'Arian', 'Guillermo', 'Zain', 'Rayden', 'Brodie', 'Crew', 'Memphis', 'Kelvin', 'Stanley', 'Joey', 'Emery', 'Terrance', 'Channing', 'Edison', 'Lennon', 'Demetrius', 'Amos', 'Cayson', 'Rodney', 'Cory', 'Elian', 'Xzavier', 'Bronson', 'Bentlee', 'Lee', 'Dayton', 'Chad', 'Cassius', 'Jagger', 'Fletcher', 'Omari', 'Alonso', 'Yosef', 'Westin', 'Brenden', 'Makai', 'Felipe', 'Harry', 'Alden', 'Maxim', 'Nickolas', 'Davion', 'Forrest', 'Allan', 'Enoch', 'Willie', 'Ben', 'Terrence', 'Tommy', 'Adonis', 'Cain', 'Harper', 'Callum', 'Jermaine', 'Kody', 'Thaddeus', 'Ray', 'Kamari', 'Aydin', 'Zeke', 'Markus', 'Ariel', 'Elisha', 'Lucca', 'Marcelo', 'Shaun', 'Aryan', 'Vicente', 'Aron', 'Keagan', 'Marlon', 'Langston', 'Ulises', 'Anders', 'Kareem', 'Bobby', 'Davian', 'Kendall', 'Ronnie', 'Jadiel', 'Samir', 'Alexzander', 'Hassan', 'Kingsley', 'Axton', 'Trace', 'Will', 'Jamal', 'Valentino', 'Yousef', 'Brecken', 'Fisher', 'Giovani', 'Kaysen', 'Maxton', 'Mayson', 'Van', 'Hezekiah', 'Blaze', 'Kolten', 'Misael', 'Javon', 'Kolby', 'Rogelio', 'Ares', 'Jedidiah', 'Bode', 'Leandro', 'Cedric', 'Jamie', 'Rowen', 'Urijah', 'Wayne', 'Eugene', 'Kole', 'Camron', 'Darian', 'Billy', 'Kase', 'Rene', 'Duncan', 'Adrien', 'Alfred', 'Maison', 'Apollo', 'Braeden', 'Mack', 'Clyde', 'Reginald', 'Anson', 'Jerome', 'Ishaan', 'Jessie', 'Javion', 'Micheal', 'Vincenzo', 'Camdyn', 'Gauge', 'Keenan', 'Gerald', 'Franco', 'Junior', 'Justus', 'Jamir', 'Marley', 'Terrell', 'Giancarlo', 'Braiden', 'Brantlee', 'Draven', 'Titan', 'Harold', 'Landry', 'Zayn', 'Briggs', 'Kyree', 'Chaim', 'Dilan', 'Joziah', 'Marquis', 'Jonathon', 'Azariah', 'Kenny', 'Amare', 'Brent', 'Clay', 'Stetson', 'Tyrone', 'Blaise', 'Dariel', 'Lamar', 'Reuben', 'Alfonso', 'Axl', 'Stefan', 'Finnley', 'Marcel', 'Jaydon', 'Kalel', 'Triston', 'Darrell', 'Steve', 'Abdiel', 'Lyric', 'Gibson', 'Thatcher', 'Henrik', 'Jadon', 'Jairo', 'Rudy', 'Castiel', 'Emory', 'Hugh', 'Konnor', 'Graysen', 'Cristiano', 'Deshawn', 'Eliezer', 'Kamdyn', 'Miller', 'Rylee', 'Tristian', 'Agustin', 'Ernest', 'Dwayne', 'Dimitri', 'Ford', 'Rey', 'Zavier', 'Arnav', 'Santana', 'Vance', 'Jamarion', 'Ramiro', 'Sonny', 'Brice', 'Leighton', 'Gilbert', 'Jordyn', 'Kaeden', 'Anton', 'Coen', 'Salvatore', 'Seamus', 'Zaire', 'Aaden', 'Chevy', 'Lachlan', 'Rolando', 'Aydan', 'Darwin', 'Randall', 'Santos', 'Yael', 'Grey', 'Kohen', 'Rashad', 'Jayse', 'Lochlan', 'Mustafa', 'Johnathon', 'Kannon', 'Konner', 'Jovani', 'Maximo', 'Alvaro', 'Clinton', 'Aidyn', 'Kymani', 'Davin', 'Jordy', 'Ephraim', 'Frankie', 'Heath', 'Houston', 'Kamron', 'Craig', 'Cristopher', 'Gordon', 'Harlan', 'Turner', 'Vaughn', 'Vivaan', 'Ameer', 'Gavyn', 'Gino', 'Jovanni', 'Benton', 'Rodolfo', 'Dominique', 'Jaycob', 'Jericho', 'Augustine', 'Coleman', 'Dash', 'Eliseo', 'Khalid', 'Quintin', 'Makhi', 'Zaid', 'Anakin', 'Baylor', 'Emmet', 'Judson', 'Truman', 'Camilo', 'Efrain', 'Semaj', 'Camren', 'Damari', 'Kamryn', 'Deangelo', 'Giovanny', 'Mike', 'Dario', 'Kale', 'Broderick', 'Jayvion', 'Kaison', 'Koen', 'Magnus', 'Darien', 'Teagan', 'Valentin', 'Bodie', 'Brayson', 'Chace', 'Kylen', 'Yehuda', 'Bridger', 'Howard', 'Maddux', 'Osvaldo', 'Rocky', 'Ayan', 'Boden', 'Foster', 'Jair', 'Reyansh', 'Tyree', 'Ean', 'Leif', 'Reagan', 'Rylen', 'Emma', 'Olivia', 'Sophia', 'Isabella', 'Ava', 'Mia', 'Emily', 'Abigail', 'Madison', 'Charlotte', 'Sofia', 'Elizabeth', 'Amelia', 'Evelyn', 'Ella', 'Chloe', 'Victoria', 'Aubrey', 'Grace', 'Zoey', 'Natalie', 'Addison', 'Lillian', 'Brooklyn', 'Lily', 'Hannah', 'Layla', 'Scarlett', 'Aria', 'Zoe', 'Samantha', 'Anna', 'Leah', 'Audrey', 'Ariana', 'Allison', 'Savannah', 'Arianna', 'Camila', 'Penelope', 'Gabriella', 'Claire', 'Aaliyah', 'Sadie', 'Nora', 'Sarah', 'Hailey', 'Kaylee', 'Paisley', 'Kennedy', 'Ellie', 'Annabelle', 'Caroline', 'Madelyn', 'Serenity', 'Aubree', 'Lucy', 'Alexa', 'Nevaeh', 'Stella', 'Violet', 'Genesis', 'Mackenzie', 'Bella', 'Autumn', 'Mila', 'Kylie', 'Maya', 'Piper', 'Alyssa', 'Eleanor', 'Melanie', 'Naomi', 'Faith', 'Eva', 'Katherine', 'Lydia', 'Brianna', 'Julia', 'Ashley', 'Khloe', 'Madeline', 'Ruby', 'Sophie', 'Alexandra', 'Lauren', 'Gianna', 'Isabelle', 'Alice', 'Vivian', 'Hadley', 'Jasmine', 'Kayla', 'Cora', 'Bailey', 'Kimberly', 'Hazel', 'Clara', 'Sydney', 'Trinity', 'Natalia', 'Valentina', 'Jocelyn', 'Maria', 'Aurora', 'Eliana', 'Brielle', 'Liliana', 'Mary', 'Elena', 'Molly', 'Makayla', 'Lilly', 'Andrea', 'Adalynn', 'Nicole', 'Delilah', 'Kinsley', 'Paige', 'Mariah', 'Brooke', 'Willow', 'Jade', 'Lyla', 'Mya', 'Ximena', 'Luna', 'Isabel', 'Mckenzie', 'Ivy', 'Josephine', 'Amy', 'Laila', 'Isla', 'Adalyn', 'Angelina', 'Londyn', 'Rachel', 'Melody', 'Juliana', 'Kaitlyn', 'Brooklynn', 'Destiny', 'Gracie', 'Norah', 'Emilia', 'Elise', 'Sara', 'Aliyah', 'Margaret', 'Catherine', 'Vanessa', 'Katelyn', 'Gabrielle', 'Arabella', 'Valeria', 'Valerie', 'Adriana', 'Everly', 'Jessica', 'Daisy', 'Makenzie', 'Summer', 'Lila', 'Rebecca', 'Julianna', 'Callie', 'Michelle', 'Ryleigh', 'Presley', 'Alaina', 'Angela', 'Alina', 'Harmony', 'Rose', 'Athena', 'Adelyn', 'Alana', 'Izabella', 'Cali', 'Esther', 'Fiona', 'Stephanie', 'Cecilia', 'Kate', 'Kinley', 'Jayla', 'Genevieve', 'Alexandria', 'Eliza', 'Kylee', 'Alivia', 'Giselle', 'Arya', 'Alayna', 'Leilani', 'Adeline', 'Jennifer', 'Tessa', 'Ana', 'Melissa', 'Daniela', 'Aniyah', 'Daleyza', 'Keira', 'Lucia', 'Hope', 'Gabriela', 'Mckenna', 'Brynlee', 'Lola', 'Amaya', 'Miranda', 'Maggie', 'Anastasia', 'Leila', 'Lexi', 'Georgia', 'Kenzie', 'Iris', 'Jacqueline', 'Cassidy', 'Vivienne', 'Camille', 'Noelle', 'Adrianna', 'Josie', 'Juliette', 'Annabella', 'Allie', 'Juliet', 'Kendra', 'Sienna', 'Brynn', 'Kali', 'Maci', 'Danielle', 'Haley', 'Jenna', 'Raelynn', 'Delaney', 'Paris', 'Alexia', 'Gemma', 'Lilliana', 'Chelsea', 'Evangeline', 'Ayla', 'Kayleigh', 'Lena', 'Katie', 'Elaina', 'Olive', 'Madeleine', 'Makenna', 'Elsa', 'Nova', 'Nadia', 'Alison', 'Kaydence', 'Journey', 'Jada', 'Kathryn', 'Shelby', 'Nina', 'Elliana', 'Diana', 'Phoebe', 'Alessandra', 'Eloise', 'Nyla', 'Madilyn', 'Adelynn', 'Miriam', 'Ashlyn', 'Amiyah', 'Megan', 'Amber', 'Rosalie', 'Annie', 'Lilah', 'Charlee', 'Amanda', 'Ruth', 'Adelaide', 'June', 'Laura', 'Daniella', 'Mikayla', 'Raegan', 'Jane', 'Ashlynn', 'Kelsey', 'Erin', 'Christina', 'Joanna', 'Fatima', 'Allyson', 'Talia', 'Mariana', 'Sabrina', 'Haven', 'Ainsley', 'Cadence', 'Elsie', 'Leslie', 'Heaven', 'Arielle', 'Maddison', 'Alicia', 'Briella', 'Lucille', 'Malia', 'Selena', 'Heidi', 'Kyleigh', 'Kira', 'Lana', 'Sierra', 'Kiara', 'Paislee', 'Alondra', 'Daphne', 'Carly', 'Jaylah', 'Kyla', 'Bianca', 'Baylee', 'Cheyenne', 'Macy', 'Camilla', 'Catalina', 'Gia', 'Vera', 'Skye', 'Aylin', 'Sloane', 'Myla', 'Yaretzi', 'Giuliana', 'Macie', 'Veronica', 'Esmeralda', 'Lia', 'Averie', 'Addyson', 'Mckinley', 'Ada', 'Carmen', 'Mallory', 'Jillian', 'Ariella', 'Rylie', 'Abby', 'Scarlet', 'Bethany', 'Elle', 'Jazmin', 'Aspen', 'Camryn', 'Malaysia', 'Haylee', 'Nayeli', 'Gracelyn', 'Kamila', 'Helen', 'Marilyn', 'April', 'Carolina', 'Amina', 'Julie', 'Raelyn', 'Blakely', 'Angelique', 'Miracle', 'Emely', 'Jayleen', 'Kennedi', 'Amira', 'Briana', 'Gwendolyn', 'Zara', 'Aleah', 'Itzel', 'Bristol', 'Francesca', 'Emersyn', 'Aubrie', 'Karina', 'Nylah', 'Kelly', 'Anaya', 'Maliyah', 'Evelynn', 'Ember', 'Melany', 'Angelica', 'Jimena', 'Madelynn', 'Kassidy', 'Tiffany', 'Kara', 'Jazmine', 'Jayda', 'Dahlia', 'Alejandra', 'Sarai', 'Annabel', 'Holly', 'Janelle', 'Braelyn', 'Gracelynn', 'Viviana', 'Serena', 'Brittany', 'Annalise', 'Brinley', 'Madisyn', 'Eve', 'Cataleya', 'Joy', 'Caitlyn', 'Anabelle', 'Emmalyn', 'Journee', 'Celeste', 'Brylee', 'Luciana', 'Marlee', 'Savanna', 'Anya', 'Marissa', 'Jazlyn', 'Zuri', 'Kailey', 'Crystal', 'Michaela', 'Lorelei', 'Guadalupe', 'Madilynn', 'Maeve', 'Hanna', 'Priscilla', 'Kyra', 'Lacey', 'Nia', 'Charley', 'Juniper', 'Cynthia', 'Karen', 'Sylvia', 'Aleena', 'Caitlin', 'Felicity', 'Elisa', 'Julissa', 'Rebekah', 'Evie', 'Helena', 'Imani', 'Karla', 'Millie', 'Lilian', 'Raven', 'Harlow', 'Leia', 'Kailyn', 'Lillie', 'Amara', 'Kadence', 'Lauryn', 'Cassandra', 'Kaylie', 'Madalyn', 'Anika', 'Hayley', 'Bria', 'Colette', 'Henley', 'Regina', 'Alanna', 'Azalea', 'Fernanda', 'Jaliyah', 'Anabella', 'Adelina', 'Lilyana', 'Skyla', 'Addisyn', 'Zariah', 'Bridget', 'Braylee', 'Monica', 'Gloria', 'Johanna', 'Addilyn', 'Danna', 'Selah', 'Aryanna', 'Kaylin', 'Aniya', 'Willa', 'Angie', 'Kaia', 'Kaliyah', 'Anne', 'Tiana', 'Charleigh', 'Winter', 'Danica', 'Alayah', 'Aisha', 'Bailee', 'Kenley', 'Aileen', 'Lexie', 'Janiyah', 'Braelynn', 'Liberty', 'Katelynn', 'Mariam', 'Sasha', 'Lindsey', 'Montserrat', 'Cecelia', 'Mikaela', 'Kaelyn', 'Rosemary', 'Annika', 'Tatiana', 'Marie', 'Virginia', 'Liana', 'Matilda', 'Freya', 'Lainey', 'Hallie', 'Audrina', 'Blake', 'Hattie', 'Monserrat', 'Kiera', 'Laylah', 'Greta', 'Alyson', 'Emilee', 'Maryam', 'Melina', 'Dayana', 'Jaelynn', 'Beatrice', 'Frances', 'Elisabeth', 'Saige', 'Kensley', 'Meredith', 'Aranza', 'Rosa', 'Shiloh', 'Charli', 'Elyse', 'Alani', 'Mira', 'Lylah', 'Linda', 'Whitney', 'Alena', 'Jaycee', 'Joselyn', 'Ansley', 'Kynlee', 'Miah', 'Tenley', 'Breanna', 'Emelia', 'Maia', 'Edith', 'Pearl', 'Anahi', 'Coraline', 'Samara', 'Demi', 'Chanel', 'Kimber', 'Lilith', 'Malaya', 'Jemma', 'Myra', 'Bryanna', 'Laney', 'Jaelyn', 'Kaylynn', 'Kallie', 'Natasha', 'Nathalie', 'Perla', 'Amani', 'Lilianna', 'Madalynn', 'Blair', 'Elianna', 'Karsyn', 'Lindsay', 'Elaine', 'Dulce', 'Ellen', 'Erica', 'Maisie', 'Renata', 'Kiley', 'Marina', 'Remi', 'Emmy', 'Ivanna', 'Amirah', 'Livia', 'Amelie', 'Irene', 'Mabel', 'Cara', 'Ciara', 'Kathleen', 'Jaylynn', 'Caylee', 'Lea', 'Erika', 'Paola', 'Alma', 'Courtney', 'Mae', 'Kassandra', 'Maleah', 'Leyla', 'Mina', 'Ariah', 'Christine', 'Jasmin', 'Kora', 'Chaya', 'Karlee', 'Lailah', 'Mara', 'Jaylee', 'Raquel', 'Siena', 'Desiree', 'Hadassah', 'Kenya', 'Aliana', 'Wren', 'Amiya', 'Isis', 'Zaniyah', 'Avah', 'Amia', 'Cindy', 'Eileen', 'Madyson', 'Celine', 'Aryana', 'Everleigh', 'Isabela', 'Reyna', 'Teresa', 'Jolene', 'Marjorie', 'Myah', 'Clare', 'Claudia', 'Leanna', 'Noemi', 'Corinne', 'Simone', 'Alia', 'Brenda', 'Dorothy', 'Emilie', 'Elin', 'Tori', 'Martha', 'Ally', 'Arely', 'Leona', 'Patricia', 'Sky', 'Thalia', 'Carolyn', 'Nataly', 'Paityn', 'Shayla', 'Averi', 'Jazlynn', 'Margot', 'Lisa', 'Lizbeth', 'Nancy', 'Deborah', 'Ivory', 'Khaleesi', 'Meadow', 'Yareli', 'Farrah', 'Milania', 'Janessa', 'Milana', 'Zoie', 'Adele', 'Clarissa', 'Lina', 'Sariah', 'Emmalynn', 'Galilea', 'Hailee', 'Halle', 'Sutton', 'Giana', 'Thea', 'Denise', 'Naya', 'Kristina', 'Liv', 'Nathaly', 'Wendy', 'Aubrielle', 'Brenna', 'Danika', 'Monroe', 'Celia', 'Dana', 'Jolie', 'Taliyah', 'Miley', 'Yamileth', 'Jaylene', 'Saylor', 'Joyce', 'Milena', 'Zariyah', 'Sandra', 'Ariadne', 'Aviana', 'Mollie', 'Cherish', 'Alaya', 'Asia', 'Nola', 'Penny', 'Dixie', 'Marisol', 'Adrienne', 'Kori', 'Kristen', 'Aimee', 'Esme', 'Laurel', 'Aliza', 'Roselyn', 'Sloan', 'Lorelai', 'Jenny', 'Katalina', 'Lara', 'Amya', 'Ayleen', 'Aubri', 'Ariya', 'Carlee', 'Iliana', 'Magnolia', 'Aurelia', 'Evalyn', 'Natalee', 'Rayna', 'Heather', 'Collins', 'Estrella', 'Hana', 'Kenna', 'Jordynn', 'Rosie', 'Aiyana', 'America', 'Angeline', 'Janiya', 'Jessa', 'Tegan', 'Susan', 'Emmalee', 'Taryn', 'Temperance', 'Alissa', 'Kenia', 'Abbigail', 'Briley', 'Kailee', 'Zaria', 'Chana', 'Lillianna', 'Barbara', 'Carla', 'Aliya', 'Bonnie', 'Keyla', 'Marianna', 'Paloma', 'Jewel', 'Joslyn', 'Saniyah', 'Audriana', 'Giovanna', 'Hadleigh', 'Mckayla', 'Jaida', 'Salma', 'Sharon', 'Emmaline', 'Kimora', 'Wynter', 'Avianna', 'Amalia', 'Karlie', 'Kaidence', 'Kairi', 'Libby', 'Sherlyn', 'Diamond', 'Holland', 'Zendaya', 'Mariyah', 'Zainab', 'Alisha', 'Ayanna', 'Ellison', 'Harlee', 'Lilyanna', 'Bryleigh', 'Julianne', 'Kaleigh', 'Miya', 'Yasmin', 'Anniston', 'Estelle', 'Emmeline', 'Faye', 'Kiana', 'Anabel', 'Tara', 'Astrid', 'Emerie', 'Sidney', 'Zahra', 'Jaylin', 'Kinslee', 'Tabitha', 'Aubriella', 'Addilynn', 'Alyvia', 'Hadlee', 'Ingrid', 'Lilia', 'Macey', 'Azaria', 'Kaitlynn', 'Neriah', 'Annabell', 'Ariyah', 'Janae', 'Kaiya', 'Reina', 'Rivka', 'Alisa', 'Marleigh', 'Alisson', 'Maliah', 'Mercy', 'Noa', 'Scarlette', 'Clementine', 'Frida', 'Ann', 'Sonia', 'Alannah', 'Avalynn', 'Dalia', 'Ayva', 'Stevie', 'Judith', 'Paulina', 'Estella', 'Gwen', 'Mattie', 'Milani', 'Raina', 'Julieta', 'Renee', 'Lesly', 'Abrielle', 'Bryn', 'Carlie', 'Riya', 'Abril', 'Aubrianna', 'Jocelynn', 'Kylah', 'Louisa', 'Pyper', 'Antonia', 'Magdalena', 'Moriah', 'Ryann', 'Tamia', 'Kailani', 'Aya', 'Ireland', 'Mercedes', 'Rosalyn', 'Alaysia', 'Annalee', 'Patience', 'Aanya', 'Paula', 'Samiyah', 'Yaritza', 'Cordelia', 'Nala', 'Belen', 'Cambria', 'Natalya', 'Kaelynn');
        shuffle($data['userNames']);
        $data['userNames'] = array_slice($data['userNames'], 0, mt_rand(1200, 1500));
        $data['streamTitles'] = array(
            '{{user}} goes live!',
            'Fun with {{topic}} and {{user}}',
            '{{topic}}?? Yeah, {{topic}}!',
            'Today is {{topic}} day',
            'Come on and have fun with {{user}}!',
            'The origins of {{topic}}',
            'Relax stream',
        );
        $data['streamDefinitions'] = array(
            array('width' => 1920, 'height' => 1080, 'bitrateMin' => 1000, 'bitrateMax' => 3500),
            array('width' => 1280, 'height' => 720, 'bitrateMin' => 750, 'bitrateMax' => 1500),
            array('width' => 720, 'height' => 400, 'bitrateMin' => 500, 'bitrateMax' => 800),
        );

        // Prepare ingest related data
        $ingestId = $uuid::generateV4();
        $ingestName = 'neap';
        $ingestHostname = 'rtmp.neap.dev';
        $ingestPort = '1935';
        $ingestAvailability = 1.0;

        // Build the ingest related SQL query
        $this->addStatement('ingest', array(
            'ingest_id' => $ingestId,
            'name' => $ingestName,
            'hostname' => $ingestHostname,
            'port' => $ingestPort,
            'availability' => $ingestAvailability,
        ));

        // Output console that we generated some SQL
        echo '1 ingest' . PHP_EOL;

        // Reference the list of outage
        for ($outageIndex = 0; $outageIndex < 10; $outageIndex++) {
            // Prepare outage related ID
            $outageId = $uuid::generateV4();

            // Prepare topic specific data
            $outageStartedAtTime = $dateConverter::randomTimestamp(1420070400);
            $outageStartedAt = $dateConverter::fromTimestamp($outageStartedAtTime);
            $outageEndedAt = $dateConverter::fromTimestamp($outageStartedAtTime + mt_rand(1, 2 * 3600));

            // Build the outage related SQL query
            $this->addStatement('outage', array(
                'outage_id' => $outageId,
                'ingest_id' => $ingestId,
                'started_at' => $outageStartedAt,
                'ended_at' => $outageEndedAt,
            ));
        }

        // Output console that we generated some SQL
        echo ($outageIndex + 1) . ' outages' . PHP_EOL;

        // Reference the list of topics
        foreach ($data['topics'] as $topicId => $topicName) {
            // Prepare topic specific data
            $topicCreatedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp(1420070400));

            // Build the topic related SQL query
            $this->addStatement('topic', array(
                'topic_id' => $topicId,
                'name' => $topicName,
                'created_at' => $topicCreatedAt,
            ));
        }

        // Output console that we generated some SQL
        echo count($this->sql['topic']['data']) . ' topics' . PHP_EOL;

        foreach ($data['teamNames'] as $teamId => $teamDisplayName) {
            // Prepare topic specific data
            $teamName = str_replace(' ', '_', strtolower($teamDisplayName));
            $teamLogo = 'http://lorempixel.com/80/80/';
            $teamBanner = 'http://lorempixel.com/900/480/';
            $teamBackground = 'http://lorempixel.com/1920/1080/';
            $teamCreatedAtTime = $dateConverter::randomTimestamp(1420070400);
            $teamCreatedAt = $dateConverter::fromTimestamp($teamCreatedAtTime);
            $teamUpdatedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp($teamCreatedAtTime));

            // Build the team related SQL query
            $this->addStatement('team', array(
                'team_id' => $teamId,
                'name' => $teamName,
                'display_name' => $teamDisplayName,
                'logo' => $teamLogo,
                'banner' => $teamBanner,
                'background' => $teamBackground,
                'created_at' => $teamCreatedAt,
                'updated_at' => $teamUpdatedAt,
            ));
        }

        // Output console that we generated some SQL
        echo count($this->sql['team']['data']) . ' teams' . PHP_EOL;

        // Reference each retained user
        foreach ($data['userNames'] as $userDisplayName) {
            // Prepare user related IDs
            $userId = $uuid::generateV4();
            $channelId = $uuid::generateV4();
            $chatId = $uuid::generateV4();

            // Prepare user specific data
            $username = strtolower($userDisplayName);
            $userEmail = $username . '@neap.io';
            $userPassword = password_hash($username, PASSWORD_BCRYPT, ['cost' => 10]);
            $userLogo = 'https://gravatar.com/avatar/' . md5($userEmail) . '?s=128&d=identicon';
            $userCreatedAtTime = $dateConverter::randomTimestamp(1420070400);
            $userCreatedAt = $dateConverter::fromTimestamp($userCreatedAtTime);
            $userUpdatedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp($userCreatedAtTime));

            // Build the user related SQL query
            $this->addStatement('user', array(
                'user_id' => $userId,
                'channel_id' => $channelId,
                'type' => 'user',
                'username' => $username,
                'email' => $userEmail,
                'password' => $userPassword,
                'display_name' => $userDisplayName,
                'logo' => $userLogo,
                'bio' => 'This is the bio of ' . $userDisplayName . '.',
                'created_at' => $userCreatedAt,
                'updated_at' => $userUpdatedAt,
            ));

            // Is user part of one or more teams?
            $userTeamCount = mt_rand(0, 14) - 9;
            if ($userTeamCount > 0) {
                $memberTeamIdList = array_rand($data['teamNames'], $userTeamCount);
                if (!is_array($memberTeamIdList)) {
                    $memberTeamIdList = [$memberTeamIdList];
                }
                foreach ($memberTeamIdList as $memberTeamId) {
                    // Prepare user specific data
                    $memberCreatedAt = $dateConverter::fromTimestamp($userCreatedAtTime);

                    // Build the user related SQL query
                    $this->addStatement('member', array(
                        'user_id' => $userId,
                        'team_id' => $memberTeamId,
                        'created_at' => $memberCreatedAt,
                    ));
                }
            }

            // Prepare channel specific data
            $channelStreamKey =
                'live_' .
                bin2hex(openssl_random_pseudo_bytes(4)) .
                '_' .
                bin2hex(openssl_random_pseudo_bytes(12));
            $channelTopicId = array_rand($data['topics']);
            $channelTopic = $data['topics'][$channelTopicId];
            $channelLanguage = 'en';
            $channelDelay = mt_rand(0, 99) < 10 ? mt_rand(10, 120) : 0;
            $channelLogo = 'http://lorempixel.com/80/80/';
            $channelBanner = 'http://lorempixel.com/900/480/';
            $channelVideoBanner = 'http://lorempixel.com/1920/1080/';
            $channelBackground = 'http://lorempixel.com/1920/1080/';
            $channelProfileBanner = 'http://lorempixel.com/900/480/';
            $channelViews = mt_rand(0, 100000);
            $channelFollowers = mt_rand(0, 99) < 5 ? mt_rand(0, count($data['teamNames'])) : mt_rand(0, 150);
            // Creation date is later than the user
            $channelCreatedAtTime = $dateConverter::randomTimestamp($userCreatedAtTime);
            $channelCreatedAt = $dateConverter::fromTimestamp($channelCreatedAtTime);
            // Update date is later than the creation
            $channelUpdatedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp($channelCreatedAtTime));

            // Build the channel related SQL query
            $this->addStatement('channel', array(
                'channel_id' => $channelId,
                'user_id' => $userId,
                'chat_id' => $chatId,
                'stream_key' => $channelStreamKey,
                'name' => $username,
                'title' => $userDisplayName . ' Channel',
                'topic' => $channelTopic,
                'language' => $channelLanguage,
                'delay' => $channelDelay,
                'logo' => $channelLogo,
                'banner' => $channelBanner,
                'video_banner' => $channelVideoBanner,
                'background' => $channelBackground,
                'profile_banner' => $channelProfileBanner,
                'views' => $channelViews,
                'followers' => $channelFollowers,
                'created_at' => $channelCreatedAt,
                'updated_at' => $channelUpdatedAt,
            ));

            // Add some panels to the Channel
            for ($panelIndex = 0; $panelIndex < mt_rand(0, 10); $panelIndex++) {
                // Prepare channel specific data
                $panelId = $uuid::generateV4();
                $panelTitle = 'Panel ' . ($panelIndex + 1);
                $panelPosition = $panelIndex;
                $panelBanner = 'http://lorempixel.com/320/80/';
                $panelBannerLink = null;
                $panelDescription = '';
                // Creation date is later than the user
                $panelCreatedAtTime = $dateConverter::randomTimestamp($channelCreatedAtTime);
                $panelCreatedAt = $dateConverter::fromTimestamp($panelCreatedAtTime);
                // Update date is later than the creation
                $panelUpdatedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp($panelCreatedAtTime));

                // Build the panel related SQL query
                $this->addStatement('panel', array(
                    'panel_id' => $panelId,
                    'channel_id' => $channelId,
                    'title' => $panelTitle,
                    'position' => $panelPosition,
                    'banner' => $panelBanner,
                    'banner_link' => $panelBannerLink,
                    'description' => $panelDescription,
                    'created_at' => $panelCreatedAt,
                    'updated_at' => $panelUpdatedAt,
                ));
            }

            // Build the chat related SQL query
            $this->addStatement('chat', array(
                'chat_id' => $chatId,
                'channel_id' => $channelId,
                'name' => $username,
            ));

            // Reference a random amount of streams for the channel
            for ($streamIndex = 0; $streamIndex < mt_rand(0, 20); $streamIndex++) {
                // Prepare stream specific data
                $streamId = $uuid::generateV4();
                $streamTopicId = array_rand($data['topics']);
                $streamTopic = $data['topics'][$streamTopicId];
                $streamTitle = str_replace(
                    array('{{user}}', '{{topic}}'),
                    array($userDisplayName, $streamTopic),
                    $data['streamTitles'][array_rand($data['streamTitles'])]
                );
                $streamDefinition = $data['streamDefinitions'][array_rand($data['streamDefinitions'])];
                $streamMediaInfo = json_encode(array(
                    'width' => $streamDefinition['width'],
                    'height' => $streamDefinition['height'],
                    'bitrate' => mt_rand(
                        $streamDefinition['bitrateMin'] * 100,
                        $streamDefinition['bitrateMax'] * 100
                    ) / 100,
                ));
                $streamViewers = mt_rand(0, 99) < 10 ? mt_rand(0, 100000) : mt_rand(0, 2000);

                // 1/100 chance of a live stream
                if (mt_rand(0, 100) === 100) {
                    // Creation date is less than one hour from now
                    $streamCreatedAtTime = $dateConverter::randomTimestamp(microtime(true) - 3600);
                    $streamCreatedAt = $dateConverter::fromTimestamp($streamCreatedAtTime);
                    // Update date is later than the creation
                    $streamUpdatedAtTime = $dateConverter::randomTimestamp($streamCreatedAtTime);
                    $streamUpdatedAt = $dateConverter::fromTimestamp($streamUpdatedAtTime);
                    // End date is null
                    $streamEndedAt = null;
                } else {
                    // Creation date is later than the channel
                    $streamCreatedAtTime = $dateConverter::randomTimestamp($userCreatedAtTime);
                    $streamCreatedAt = $dateConverter::fromTimestamp($streamCreatedAtTime);
                    // Update date is later than the creation
                    $streamUpdatedAtTime = $dateConverter::randomTimestamp(
                        $streamCreatedAtTime,
                        $streamCreatedAtTime + mt_rand(0, 10 * 3600)
                    );
                    $streamUpdatedAt = $dateConverter::fromTimestamp($streamUpdatedAtTime);
                    // End date is later than the update
                    $streamEndedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp(
                        $streamUpdatedAtTime,
                        $streamUpdatedAtTime + mt_rand(0, 2 * 3600)
                    ));
                }

                // Build the stream related SQL query
                $this->addStatement('stream', array(
                    'stream_id' => $streamId,
                    'channel_id' => $channelId,
                    'ingest_id' => $ingestId,
                    'title' => $streamTitle,
                    'topic_id' => $streamTopicId,
                    'topic' => $streamTopic,
                    'media_info' => $streamMediaInfo,
                    'viewers' => $streamViewers,
                    'created_at' => $streamCreatedAt,
                    'updated_at' => $streamUpdatedAt,
                    'ended_at' => $streamEndedAt,
                ));

                // Reference a random amount of videos for the stream
                for ($videoIndex = 0; $videoIndex < mt_rand(0, 2); $videoIndex++) {
                    // Prepare video specific data
                    $videoId = $uuid::generateV4();
                    $videoTitle = $streamTitle;
                    $videoType = mt_rand(0, 99) < 20 ? 'highlight' : 'record';
                    $videoDescription = $streamTitle;
                    $videoStatus = 'recorded';
                    $videoTags = json_encode(array());
                    $videoTopicId = $streamTopicId;
                    $videoTopic = $streamTopic;
                    $videoMediaInfo = json_encode(array(
                        'width' => $streamDefinition['width'],
                        'height' => $streamDefinition['height'],
                        'bitrate' => mt_rand(
                            $streamDefinition['bitrateMin'] * 100,
                            $streamDefinition['bitrateMax'] * 100
                        ) / 100,
                    ));
                    $videoPreview = null;
                    $videoViews = mt_rand(0, 40000);
                    // Creation date is later than the stream
                    $videoCreatedAtTime = $dateConverter::randomTimestamp($streamCreatedAtTime);
                    $videoCreatedAt = $dateConverter::fromTimestamp($videoCreatedAtTime);
                    // Update date is later than the creation
                    $videoUpdatedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp(
                        $videoCreatedAtTime,
                        $videoCreatedAtTime + mt_rand(0, 7 * 24 * 3600)
                    ));

                    // Build the video related SQL query
                    $this->addStatement('video', array(
                        'video_id' => $videoId,
                        'stream_id' => $streamId,
                        'title' => $videoTitle,
                        'type' => $videoType,
                        'description' => $videoDescription,
                        'status' => $videoStatus,
                        'tags' => $videoTags,
                        'topic_id' => $videoTopicId,
                        'topic' => $videoTopic,
                        'media_info' => $videoMediaInfo,
                        'preview' => $videoPreview,
                        'views' => $videoViews,
                        'created_at' => $videoCreatedAt,
                        'updated_at' => $videoUpdatedAt,
                    ));

                    $favorites = array();

                    for ($favoriteIndex = 0; $favoriteIndex < mt_rand(0, round($videoViews / 100)); $favoriteIndex++) {
                        // Check for unicity
                        $favoriteUser = $this->sql['user']['data'][array_rand($this->sql['user']['data'])];
                        if (in_array($favoriteUser, $favorites)) {
                            continue;
                        }
                        $favorites[] = $favoriteUser;
                        // Prepare block specific data
                        $favoriteCreatedAtTime = $dateConverter::randomTimestamp(1420070400);
                        $favoriteCreatedAt = $dateConverter::fromTimestamp($favoriteCreatedAtTime);

                        // Build the block related SQL query
                        $this->addStatement('favorite', array(
                            'user_id' => $favoriteUser['user_id'],
                            'video_id' => $videoId,
                            'created_at' => $favoriteCreatedAt,
                        ));
                    }

                }
            }
        }

        // Output console that we generated some SQL
        echo count($this->sql['user']['data']) . ' users' . PHP_EOL;
        echo count($this->sql['member']['data']) . ' members' . PHP_EOL;
        echo count($this->sql['channel']['data']) . ' channels' . PHP_EOL;
        echo count($this->sql['chat']['data']) . ' chats' . PHP_EOL;
        echo count($this->sql['stream']['data']) . ' streams' . PHP_EOL;
        echo count($this->sql['video']['data']) . ' videos' . PHP_EOL;
        echo count($this->sql['favorite']['data']) . ' favorites' . PHP_EOL;

        foreach ($this->sql['channel']['data'] as $channel) {
            $follows = array();
            $blocks = array();
            $mods = array();

            // Reference random follows between generated users and channels
            for ($followIndex = 0; $followIndex < $channel['followers']; $followIndex++) {
                // Check for unicity
                $user = $this->sql['user']['data'][array_rand($this->sql['user']['data'])];
                if (in_array($user, $follows)) {
                    continue;
                }
                $follows[] = $user;
                // Prepare follow specific data
                $followCreatedAtTime = $dateConverter::randomTimestamp(1420070400);
                $followCreatedAt = $dateConverter::fromTimestamp($followCreatedAtTime);

                // Build the follow related SQL query
                $this->addStatement('follow', array(
                    'user_id' => $user['user_id'],
                    'channel_id' => $channel['channel_id'],
                    'created_at' => $followCreatedAt,
                ));
            }

            // Reference blocks for one user out of 100
            if (mt_rand(0, 50) === 50) {
                for ($blockIndex = 0; $blockIndex < mt_rand(0, 10); $blockIndex++) {
                    // Check for unicity
                    $blockedUser = $this->sql['user']['data'][array_rand($this->sql['user']['data'])];
                    if (in_array($blockedUser, $blocks)) {
                        continue;
                    }
                    $blocks[] = $blockedUser;
                    // Prepare block specific data
                    $blockCreatedAtTime = $dateConverter::randomTimestamp(1420070400);
                    $blockCreatedAt = $dateConverter::fromTimestamp($blockCreatedAtTime);

                    // Build the block related SQL query
                    $this->addStatement('block', array(
                        'user_id' => $user['user_id'],
                        'blocked_user_id' => $blockedUser['user_id'],
                        'created_at' => $blockCreatedAt,
                    ));
                }
            }

            // Reference mods for one user out of 100
            if (mt_rand(0, 25) === 25) {
                for ($modIndex = 0; $modIndex < mt_rand(0, 5); $modIndex++) {
                    // Check for unicity
                    $chat = $this->sql['chat']['data'][array_rand($this->sql['chat']['data'])];
                    if (in_array($chat, $mods)) {
                        continue;
                    }
                    $mods[] = $chat;
                    // Prepare mod specific data
                    $modCreatedAtTime = $dateConverter::randomTimestamp(1420070400);
                    $modCreatedAt = $dateConverter::fromTimestamp($modCreatedAtTime);
                    // Update date is later than the creation
                    $modUpdatedAt = $dateConverter::fromTimestamp($dateConverter::randomTimestamp($modCreatedAtTime));

                    // Build the mod related SQL query
                    $this->addStatement('mod', array(
                        'user_id' => $user['user_id'],
                        'chat_id' => $chat['chat_id'],
                        'level' => mt_rand(0, 99) < 5 ? 'admin' : 'operator',
                        'created_at' => $modCreatedAt,
                        'updated_at' => $modUpdatedAt,
                    ));
                }
            }
        }

        // Output console that we generated some SQL
        echo count($this->sql['follow']['data']) . ' follows' . PHP_EOL;
        echo count($this->sql['block']['data']) . ' blocks' . PHP_EOL;
        echo count($this->sql['mod']['data']) . ' mods' . PHP_EOL;

        // Finish the SQL script by committing the whole huge transaction we generated
        // We do not want partial fixtures
        $this->addStatement('after', 'COMMIT;');

        // Output the script to a SQL script file
        $this->writeFile();
    }
}
