<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MON SUPER SITE</title>
    <style>
        @import "https://unpkg.com/open-props/normalize.min.css";
        @import "https://unpkg.com/open-props/open-props.min.css";

        :root {
            --lerp-0: 1;
            /* === sin(90deg) */
            --lerp-1: calc(sin(30deg));
            --lerp-2: calc(sin(20deg));
            --lerp-3: calc(sin(10deg));
            --lerp-4: 0;
            --transition: ease;
        }

        p {
            color: white;
            font-size: 3em;
            text-align: center;
        }

        *,
        *:after,
        *:before {
            box-sizing: border-box;
        }

        h1 {
            position: fixed;
            top: var(--size-4);
            right: var(--size-4);
            margin: 0;
            color: var(--gray-0);
        }

        body {
            display: grid;
            place-items: center;
            min-height: 100vh;
            font-family: 'Google Sans', sans-serif, system-ui;
            background: var(--gradient-6);
        }

                /*:root {
        --lerp-0: 1;
        --lerp-1: 0.5625;
        --lerp-2: 0.25;
        --lerp-3: 0.0625;
        --lerp-4: 0;
        }*/

        .block:nth-of-type(1) {
            --hue: 10;
        }

        .block:nth-of-type(2) {
            --hue: 210;
        }

        .block:nth-of-type(3) {
            --hue: 290;
        }

        .block:nth-of-type(4) {
            --hue: 340;
        }

        .block:nth-of-type(5) {
            --hue: 30;
        }

        .block:nth-of-type(6) {
            --hue: 220;
        }

        .block:nth-of-type(7) {
            --hue: 320;
        }

        .block:nth-of-type(8) {
            --hue: 280;
        }

        .block:nth-of-type(9) {
            --hue: 240;
        }

        .blocks {
            display: flex;
            list-style-type: none;
            padding: var(--size-2);
            border-radius: var(--radius-3);
            gap: var(--size-4);
            background: hsl(0 0% 100% / 0.5);
            box-shadow:
                0 2px 0 0 hsl(0 0% 100% / 0.5) inset,
                0 2px 0 0 hsl(0 0% 25% / 0.5);
            align-items: center;
            justify-content: center;
            align-content: center;
            backdrop-filter: blur(10px);
        }

        .blocks:hover {
            --show: 1;
        }

        .block {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            align-content: center;
            transition: all 0.2s;
            flex: calc(0.2 + (var(--lerp, 0) * 1.5));
            max-width: 100px;
            position: relative;
        }

        .block:after {
            content: '';
            width: 5%;
            aspect-ratio: 1;
            background: var(--text-1);
            position: absolute;
            bottom: 10%;
            left: 50%;
            border-radius: var(--radius-3);
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        .block:before {
            content: '';
            position: absolute;
            width: calc(100% + var(--size-4));
            bottom: 0;
            aspect-ratio: 1 / 2;
            left: 50%;
            transition: transform 0.2s var(--transition);
            transform-origin: 50% 100%;
            transform: translateX(-50%) scaleY(var(--show, 0));
            z-index: -1;
        }

        .block .block__item {
            transition: outline 0.2s var(--transition);
            outline: transparent var(--size-1) solid;
        }

        .block svg {
            width: 80%;
            transition: all 0.2s var(--transition);
            stroke: var(--gray-1);
        }

        :is(.block:focus-visible) .block__item {
            outline: var(--gray-1) var(--size-1) solid;
            border-radius: var(--radius-3);
        }

        .block {
            outline: none;
        }

        .block__item {
            width: 100%;
            aspect-ratio: 1;
            border-radius: var(--radius-2);
            background:
                linear-gradient(hsl(0 0% 100% / 0.1), transparent),
                hsl(var(--hue, 10) 70% 60%);
            display: grid;
            place-items: center;
            transition: all 0.2s var(--transition);
            box-shadow:
                0 2px 0 0 hsl(0 0% 100% / 0.5) inset,
                0 2px 0 0 hsl(0 0% 25% / 0.5);
            transform-origin: 50% 100%;
            position: relative;
            translate: 0 calc(var(--lerp) * -75%);
        }

        /*@media(prefers-color-scheme: dark) {
}*/
        body {
            background: var(--gradient-23);
        }

        .blocks {
            background: hsl(0 0% 0% / 0.5);
        }


        :is(.block:hover, .block:focus-visible) {
            --lerp: var(--lerp-0);
            z-index: 5;
        }

        .block:has(+ :is(.block:hover, .block:focus-visible)),
        :is(.block:hover, .block:focus-visible)+.block {
            --lerp: var(--lerp-1);
            z-index: 4;
        }

        .block:has(+ .block + :is(.block:hover, .block:focus-visible)),
        :is(.block:hover, .block:focus-visible)+.block+.block {
            --lerp: var(--lerp-2);
            z-index: 3;
        }

        .block:has(+ .block + .block + :is(.block:hover, .block:focus-visible)),
        :is(.block:hover, .block:focus-visible)+.block+.block+.block {
            --lerp: var(--lerp-3);
            z-index: 2;
        }

        .block:has(+ .block + .block + .block + :is(.block:hover, .block:focus-visible)),
        :is(.block:hover, .block:focus-visible)+.block+.block+.block+.block {
            --lerp: var(--lerp-4);
            z-index: 1;
        }
    </style>
</head>

<body>
    <nav class="blocks">
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
        </a>
        <a href="#" class="block">
            <div class="block__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
            </div>
        </a>
    </nav>