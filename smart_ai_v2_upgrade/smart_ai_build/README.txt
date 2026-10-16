SMART BASKET — SMART AI V2

This upgrade is based on the uploaded SMART BASKET views ZIP.
The existing views already use <x-smart-ai-robot /> and the route name customer-ai.message.

FILES
1. views/components/smart-ai-robot.blade.php
   Replace: resources/views/components/smart-ai-robot.blade.php

2. public/css/smart-ai-robot.css
   Add/replace: public/css/smart-ai-robot.css

3. public/js/smart-ai-robot.js
   Add/replace: public/js/smart-ai-robot.js

4. app/Http/Controllers/CustomerAiController.php
   Add/replace the controller.

5. routes-smart-ai.php
   Add the POST route to routes/web.php. If customer-ai.message already exists,
   do NOT create a duplicate route; point that route to this controller method instead.

6. .env.smart-ai.example
   Add GEMINI_API_KEY and GEMINI_MODEL to .env.

GOOGLE CONNECTION
The server calls Gemini's generateContent endpoint with the google_search tool.
This keeps the API key on the server and lets Gemini use Google Search grounding for
current questions. Search grounding can return source URLs which the UI displays.

VOICE
- Type mode: normal text chat.
- Live Voice mode: browser speech recognition continuously listens and sends final utterances.
- Auto-speak: reads AI replies aloud using the browser's available voices.
- Language selector changes recognition and speech locale.
- Voice selector lets the customer choose an installed browser voice.

ROBOT ACTIONS
The robot can visibly perform these browser-side actions immediately:
dance, cry, laugh, wave, jump, happy, angry, sleep, think.
These are animations inside the browser; they do not control a physical robot.

OPEN/CLOSE
The existing customer taskbar and 3-dot menu can continue opening [data-smart-ai-open].
The component launcher remains available for direct use.

IMPORTANT
A website AI cannot literally do arbitrary physical actions. It can execute browser/app
functions that you explicitly expose. For additional SMART BASKET actions (cart changes,
order lookup, product search, etc.), add authenticated server functions and expose only
safe functions to the assistant.
