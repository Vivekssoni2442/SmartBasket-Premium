/*
|--------------------------------------------------------------------------
| SMART BASKET — AI ROBOT DANCE COMMAND
|--------------------------------------------------------------------------
| Voice + Text Command
| "Dance karo"  -> Robot dances
| "Stop"        -> Robot stops
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | ROBOT
    |--------------------------------------------------------------------------
    */

    const robot = document.getElementById('aiRobot');

    if (!robot) {
        console.warn('SMART BASKET: #aiRobot not found.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | OPTIONAL ELEMENTS
    |--------------------------------------------------------------------------
    */

    const commandInput =
        document.getElementById('robotCommandInput');

    const commandButton =
        document.getElementById('robotCommandBtn');

    const voiceButton =
        document.getElementById('robotVoiceBtn');

    const status =
        document.getElementById('robotCommandStatus');


    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let isDancing = false;
    let recognition = null;


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    function setStatus(message) {

        if (status) {
            status.textContent = message;
        }

        console.log(
            'SMART BASKET ROBOT:',
            message
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DANCE START
    |--------------------------------------------------------------------------
    */

    function startDance() {

        if (isDancing) {
            return;
        }

        isDancing = true;

        robot.classList.add(
            'robot-dancing'
        );

        setStatus(
            '🤖💃 Okay! I am dancing!'
        );

        speak(
            'Okay! I am dancing!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DANCE STOP
    |--------------------------------------------------------------------------
    */

    function stopDance() {

        isDancing = false;

        robot.classList.remove(
            'robot-dancing'
        );

        setStatus(
            '🤖 Dance stopped.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TEXT COMMAND
    |--------------------------------------------------------------------------
    */

    function processCommand(command) {

        if (!command) {
            return;
        }

        const text =
            String(command)
                .trim()
                .toLowerCase();


        /*
        |--------------------------------------------------------------------------
        | DANCE COMMANDS
        |--------------------------------------------------------------------------
        */

        const danceCommands = [

            'dance',
            'dance karo',
            'dance kar',
            'dance kro',
            'dancing',
            'danced',
            'nacho',
            'nacho',
            'naacho',
            'naach',
            'naach karo',
            'नाचो',
            'नाच',
            'नाच करो',
            'डांस',
            'डांस करो',
            'डांस कर'
        ];


        /*
        |--------------------------------------------------------------------------
        | STOP COMMANDS
        |--------------------------------------------------------------------------
        */

        const stopCommands = [

            'stop',
            'stop dance',
            'dance stop',
            'ruk',
            'ruk jao',
            'ruko',
            'bas',
            'band',
            'band karo',
            'रुको',
            'रुक जाओ',
            'बस',
            'बंद करो'
        ];


        /*
        |--------------------------------------------------------------------------
        | DANCE DETECTION
        |--------------------------------------------------------------------------
        */

        const wantsDance =
            danceCommands.some(
                phrase =>
                    text === phrase ||
                    text.includes(phrase)
            );


        /*
        |--------------------------------------------------------------------------
        | STOP DETECTION
        |--------------------------------------------------------------------------
        */

        const wantsStop =
            stopCommands.some(
                phrase =>
                    text === phrase ||
                    text.includes(phrase)
            );


        if (wantsStop) {

            stopDance();

            return;
        }


        if (wantsDance) {

            startDance();

            return;
        }


        setStatus(
            `🤖 I heard: "${command}"`
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TEXT BUTTON
    |--------------------------------------------------------------------------
    */

    commandButton?.addEventListener(
        'click',
        () => {

            const command =
                commandInput?.value || '';

            processCommand(
                command
            );

            if (commandInput) {
                commandInput.value = '';
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | ENTER KEY
    |--------------------------------------------------------------------------
    */

    commandInput?.addEventListener(
        'keydown',
        event => {

            if (event.key === 'Enter') {

                event.preventDefault();

                const command =
                    commandInput.value;

                processCommand(
                    command
                );

                commandInput.value = '';
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | VOICE RECOGNITION
    |--------------------------------------------------------------------------
    */

    const SpeechRecognition =
        window.SpeechRecognition ||
        window.webkitSpeechRecognition;


    if (SpeechRecognition) {

        recognition =
            new SpeechRecognition();

        recognition.continuous = false;

        recognition.interimResults = false;

        recognition.lang = 'hi-IN';


        recognition.onstart = () => {

            setStatus(
                '🎤 Listening... Say "Dance karo"'
            );

            if (voiceButton) {
                voiceButton.classList.add(
                    'listening'
                );
            }
        };


        recognition.onresult =
            event => {

                const transcript =
                    event.results[0][0].transcript;

                console.log(
                    'Robot heard:',
                    transcript
                );

                processCommand(
                    transcript
                );
            };


        recognition.onerror =
            event => {

                console.error(
                    'Voice recognition error:',
                    event.error
                );

                setStatus(
                    '🎤 Voice command failed. Please try again.'
                );
            };


        recognition.onend = () => {

            if (voiceButton) {
                voiceButton.classList.remove(
                    'listening'
                );
            }
        };


        voiceButton?.addEventListener(
            'click',
            () => {

                try {

                    recognition.start();

                } catch (error) {

                    console.warn(
                        'Recognition already running.'
                    );
                }
            }
        );

    } else {

        if (voiceButton) {

            voiceButton.disabled = true;

            voiceButton.title =
                'Voice recognition is not supported by this browser.';
        }

        console.warn(
            'Speech Recognition is not supported.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TEXT TO SPEECH
    |--------------------------------------------------------------------------
    */

    function speak(text) {

        if (
            !('speechSynthesis' in window)
        ) {
            return;
        }

        window.speechSynthesis.cancel();

        const utterance =
            new SpeechSynthesisUtterance(
                text
            );

        utterance.lang =
            'en-IN';

        utterance.rate =
            1;

        utterance.pitch =
            1.1;

        window.speechSynthesis.speak(
            utterance
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXTERNAL COMMAND API
    |--------------------------------------------------------------------------
    | Other JavaScript can call:
    |
    | window.smartBasketRobot('dance karo')
    |
    */

    window.smartBasketRobot =
        function (command) {

            processCommand(
                command
            );
        };


    /*
    |--------------------------------------------------------------------------
    | READY
    |--------------------------------------------------------------------------
    */

    setStatus(
        '🤖 Ready. Tell me: "Dance karo"'
    );

});