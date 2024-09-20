<?php
session_start();
$username = $_SESSION['username'];
$remaining = $_SESSION['remaining'];
if (!isset($_SESSION['username'])) { 
    header('Location: ./index1.html');
    exit();
} elseif($remaining->format('%a') <= 0 && $remaining->format('%h') <= 0) {
    header('Location: shopcenter.php?err=4');
    exit();
}else{
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="简洁而强大的ChatGPT应用">
        <meta name="theme-color" content="#edeff2">
        <meta name="apple-mobile-web-app-status-bar-style" content="#edeff2">
        <meta name="msapplication-TileColor" content="#edeff2">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="msapplication-TileImage" content="icon.png">
        <link rel="manifest" crossorigin="use-credentials" href="manifest.json">
        <link rel="icon" type="image/png" href="icon.png">
        <link rel="apple-touch-icon" href="icon.png" sizes="512x512">
        <title>Try ChatGPT</title>
        <style>
            .requestBody,
            .response .markdown-body {
                max-width: calc(100% - 88px);
            }

            .bottom_wrapper {
                max-width: 100%;
            }

            * {
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Noto Sans", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            }

            html {
                width: 100%;
                height: 100%;
            }

            :root {
                --background: #edeff2;
                --chat-back: #fff;
                --main-back: #f6f6f6;
                --active-btn: #e0e0e0;
                --lighter-active: #eaeaea;
                --sel-btn: #d0d0d0;
                --btn-color: #404040;
                --text-color: #909090;
                --chat-text-color: #24292f;
                --response-color: #f7f7f8;
                --lighter-active-color: #e8e8e8;
                --lighter-text-color: #555;
                --svg-color: #808080;
                --lighter-svg-color: #c0c0c0;
                --code-color: #f0f0f0;
                --black-color: #000;
            }

            [data-theme="dark"] {
                --background: #1f1f1f;
                --chat-back: #3c3c3c;
                --main-back: #333;
                --active-btn: #1f1f1f;
                --lighter-active: #151515;
                --sel-btn: #1e1e1e;
                --btn-color: #bfbfbf;
                --text-color: #8f8f8f;
                --chat-text-color: #c9d1d9;
                --response-color: #2f2f2f;
                --lighter-active-color: #171717;
                --lighter-text-color: #aaa;
                --svg-color: #7f7f7f;
                --lighter-svg-color: #3f3f3f;
                --code-color: #101010;
                --black-color: #fff;
            }

            body {
                background-color: var(--background);
                width: 100%;
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .chat_window {
                position: absolute;
                width: 100%;
                max-width: 1188px;
                height: 100%;
                max-height: 888px;
                border-radius: 8px;
                background-color: var(--chat-back);
                overflow: hidden;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            }

            .chat_window>.overlay {
                width: 100%;
                height: 100%;
                position: absolute;
                left: 0;
                top: 0;
                background-color: rgba(0, 0, 0, .3);
                z-index: 90;
                cursor: pointer;
                visibility: hidden;
                opacity: 0;
                -webkit-tap-highlight-color: transparent;
                transition: all 250ms;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            }

            @media screen and (max-width: 1188px) and (max-height: 888px) {
                #toggleFull {
                    display: none;
                }
            }

            @media screen and (min-width: 800px) {
                .chat_window {
                    display: flex;
                }

                .mainContent {
                    width: calc(100% - 250px);
                }

                .chat_window>.nav {
                    position: relative;
                    margin-left: -250px;
                    transition: margin-left 250ms;
                    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                }

                .show-nav .nav {
                    margin-left: 0;
                }

                #sysDialog {
                    max-width: 600px;
                }

                .sysContent {
                    display: flex;
                }

                .sysSwitch {
                    flex-shrink: 0;
                    width: 160px;
                }

                .sysSwitch>div {
                    padding-left: 6px;
                }

                .sysDetail {
                    margin-left: 12px;
                    margin-top: 5px;
                }

                .setNotNormalFlow {
                    width: calc(100% - 212px);
                }
            }

            @media screen and (max-width: 800px) {
                .chat_window {
                    display: block;
                }

                .mainContent {
                    width: 100%;
                }

                .chat_window>.nav {
                    position: absolute !important;
                    left: -250px;
                    transition: left 250ms;
                    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                }

                .show-nav .nav {
                    left: 0;
                    box-shadow: rgba(0, 0, 0, 0.2) 0px 8px 10px -5px, rgba(0, 0, 0, 0.14) 0px 16px 24px 2px, rgba(0, 0, 0, 0.12) 0px 6px 30px 5px;
                }

                .show-nav .overlay {
                    visibility: visible;
                    opacity: 1;
                }

                #sysDialog {
                    max-width: 400px;
                }

                .sysSwitch {
                    display: flex;
                }

                .sysSwitch>div {
                    width: 50%;
                    justify-content: center;
                }

                .sysDetail {
                    margin-top: 8px;
                }

                .setNotNormalFlow {
                    width: calc(100% - 40px);
                }
            }

            .full_window {
                max-width: none;
                max-height: none;
            }

            .chat_window>.nav {
                width: 250px;
                height: 100%;
                border-right: 1px solid var(--active-btn);
                background-color: var(--main-back);
                top: 0;
                z-index: 99;
                flex-shrink: 0;
                display: flex;
                flex-direction: column;
            }

            .mainContent {
                height: 100%;
                position: relative;
                display: flex;
                flex-direction: column;
                flex: 1;
            }

            .top_menu {
                background-color: var(--main-back);
                width: 100%;
                height: 50px;
                padding: 5px 0;
            }

            .top_menu .toggler {
                margin-left: 10px;
                width: 40px;
                height: 40px;
                float: left;
                padding: 5px 7px;
                border-radius: 4px;
                cursor: pointer;
                -webkit-tap-highlight-color: transparent;
            }

            .top_menu .toggler:hover {
                background: var(--active-btn);
            }

            .top_menu .toggler .button {
                width: 26px;
                height: 4px;
                border-radius: 4px;
                position: absolute;
                pointer-events: none;
            }

            .top_menu .toggler .button.close {
                margin-top: 3px;
                background-color: #99c959;
            }

            .top_menu .toggler .button.minimize {
                margin-top: 13px;
                background-color: #f8b26a;
            }

            .top_menu .toggler .button.maximize {
                margin-top: 23px;
                background-color: #e15b64;
            }

            .top_menu .title {
                color: var(--text-color);
                font-size: 20px;
                height: 40px;
                line-height: 40px;
                position: relative;
                pointer-events: none;
            }

            .top_menu .title>span {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .messages {
                position: relative;
                flex: 1;
                overflow-x: hidden;
                overflow-y: auto;
                font-size: 16px;
                color: var(--chat-text-color);
                text-align: center;
            }

            .messages::-webkit-scrollbar,
            #chatlog .markdown-body pre>code::-webkit-scrollbar,
            #setDialog::-webkit-scrollbar,
            .allList::-webkit-scrollbar,
            .sysDetail::-webkit-scrollbar,
            #apiSelect::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }

            .messages::-webkit-scrollbar-track,
            #chatlog .markdown-body pre>code::-webkit-scrollbar-track,
            #setDialog::-webkit-scrollbar-track,
            .allList::-webkit-scrollbar-track,
            .sysDetail::-webkit-scrollbar-track,
            #apiSelect::-webkit-scrollbar-track {
                background-clip: padding-box;
                background: transparent;
                border: none;
            }

            .messages::-webkit-scrollbar-corner,
            #chatlog .markdown-body pre>code::-webkit-scrollbar-corner,
            #setDialog::-webkit-scrollbar-corner,
            .allList::-webkit-scrollbar-corner,
            .sysDetail::-webkit-scrollbar-corner,
            #apiSelect::-webkit-scrollbar-corner {
                background-color: transparent;
            }

            .messages::-webkit-scrollbar-thumb,
            #chatlog .markdown-body pre>code::-webkit-scrollbar-thumb,
            #setDialog::-webkit-scrollbar-thumb,
            .allList::-webkit-scrollbar-thumb,
            .sysDetail::-webkit-scrollbar-thumb,
            #apiSelect::-webkit-scrollbar-thumb {
                background-color: rgba(0, 0, 0, 0.1);
                background-clip: padding-box;
                border: solid transparent;
                border-radius: 10px;
            }

            .messages::-webkit-scrollbar-thumb:hover,
            #chatlog .markdown-body pre>code::-webkit-scrollbar-thumb:hover,
            #setDialog::-webkit-scrollbar-thumb:hover,
            .allList::-webkit-scrollbar-thumb:hover,
            .sysDetail::-webkit-scrollbar-thumb:hover,
            #apiSelect::-webkit-scrollbar-thumb:hover {
                background-color: rgba(0, 0, 0, 0.4);
            }

            #chatlog {
                word-wrap: break-word;
                text-align: start;
            }

            .chatAvatar {
                margin: 14px 14px 13px 13px;
                width: 30px;
                height: 30px;
                flex-shrink: 0;
                border-radius: 2px;
            }

            .response>.chatAvatar {
                margin-top: 15px;
                margin-bottom: 15px;
            }

            .response .gpt3Avatar {
                background: #19c37d;
            }

            .response .gpt4Avatar {
                background: #ab68ff;
            }

            .chatAvatar>img {
                display: block;
                width: 100%;
                height: 100%;
                border-radius: 2px;
            }

            .chatAvatar>svg {
                display: block;
                margin-top: 4px;
                margin-left: 4px;
            }

            #chatlog .request {
                position: relative;
                display: flex;
                justify-content: center;
            }

            .requestBody {
                white-space: pre-wrap;
                margin: 18px 0;
                flex: 1;
            }

            #chatlog .response {
                background: var(--response-color);
                position: relative;
                display: flex;
                justify-content: center;
            }

            .response .markdown-body {
                margin: 18px 0;
                flex: 1;
                background: var(--response-color) !important;
            }

            #chatlog .markdown-body a {
                padding: 0 1px 0 2px;
            }

            #chatlog .markdown-body pre {
                padding: 10px;
                position: relative;
                background: var(--code-color);
            }

            #chatlog .markdown-body pre>code {
                overflow-x: auto;
                display: block;
            }

            #chatlog .markdown-body ul {
                list-style-type: disc;
            }

            .m-mdic-copy-wrapper {
                position: absolute;
                top: 5px;
                right: 16px;
                -webkit-user-select: none;
                user-select: none;
            }

            .m-mdic-copy-wrapper span.u-mdic-copy-code_lang {
                position: absolute;
                top: 3px;
                right: calc(100% + 4px);
                font-family: system-ui;
                font-size: 12px;
                line-height: 18px;
                color: #bbb;
            }

            .m-mdic-copy-wrapper div.u-mdic-copy-notify {
                position: absolute;
                top: 0;
                right: 0;
                padding: 3px 6px;
                border: 0;
                border-radius: 3px;
                background: none;
                font-family: system-ui;
                font-size: 12px;
                line-height: 18px;
                color: var(--lighter-text-color);
                outline: none;
                right: 100%;
                padding-right: 4px;
            }

            .m-mdic-copy-wrapper button.u-mdic-copy-btn {
                position: relative;
                top: 0;
                right: 0;
                padding: 3px 6px;
                border: 0;
                border-radius: 3px;
                background: none;
                font-family: system-ui;
                font-size: 12px;
                line-height: 18px;
                color: #bbb;
                outline: none;
                cursor: pointer;
                transition: color 250ms;
            }

            .m-mdic-copy-wrapper span.u-mdic-copy-code_lang::before,
            .m-mdic-copy-wrapper div.u-mdic-copy-notify::before,
            .m-mdic-copy-wrapper button.u-mdic-copy-btn::before {
                content: attr(text);
            }

            .m-mdic-copy-wrapper button.u-mdic-copy-btn:hover {
                color: var(--lighter-text-color);
            }

            #stopChat {
                display: none;
                margin: 0 auto;
                margin-top: 3px;
                width: 80px;
                height: 32px;
                text-align: center;
                line-height: 32px;
                color: white;
                background: #f8b26a;
                cursor: pointer;
                border-radius: 3px;
                position: sticky;
                bottom: 2px;
                justify-content: center;
                align-items: center;
            }

            #stopChat>svg {
                margin-right: 8px;
            }

            #stopChat:hover {
                background: #f0aa60;
            }

            .bottom_wrapper {
                position: relative;
                width: 100%;
                padding: 10px 10px;
                margin: 0 auto;
            }

            .bottom_wrapper .message_input_wrapper {
                border: none;
                width: calc(100% - 139px);
                position: relative;
                text-align: left;
            }

            .bottom_wrapper .message_input_wrapper .message_input_text {
                border-radius: 4px;
                border: none;
                outline: none;
                resize: none;
                background-color: var(--main-back);
                color: var(--chat-text-color);
                height: 47px;
                font-size: 16px;
                max-height: 200px;
                padding: 13px 0 13px 13px;
                width: 100%;
                display: block;
                transition: background-color 250ms;
            }

            .bottom_wrapper .message_input_wrapper .message_input_text:focus {
                background-color: var(--code-color);
            }

            .bottom_wrapper .message_input_wrapper .message_input_text::-webkit-scrollbar {
                display: none;
                width: 0;
                height: 0;
            }

            #sendbutton {
                width: 80px;
                height: 47px;
                font-size: 18px;
                font-weight: bold;
                border-radius: 3px;
                background-color: #b8da8b;
                border: none;
                padding: 0;
                color: #fff;
                cursor: pointer;
                transition: all 250ms;
                text-align: center;
                float: right;
                position: absolute;
                right: 63px;
                bottom: 10px;
                cursor: not-allowed;
            }

            .activeSendBtn {
                background-color: #99c959 !important;
                cursor: pointer !important;
            }

            .activeSendBtn:hover {
                background-color: #90c050 !important;
            }

            .clearConv {
                position: absolute;
                right: 10px;
                bottom: 10px;
                width: 47px;
                height: 47px;
                border-radius: 3px;
                background: var(--text-color);
                border: none;
                color: #fff;
                cursor: pointer;
            }

            .clearConv>svg {
                margin: 0 auto;
            }

            .clearConv:hover {
                background: var(--svg-color);
            }

            .clearConv svg:first-child {
                display: none;
            }

            .clearConv svg:nth-child(2) {
                display: block;
            }

            .closeConv {
                background: var(--active-btn);
            }

            .closeConv:hover {
                background: var(--lighter-active-color);
            }

            .closeConv svg:first-child {
                display: block;
            }

            .closeConv svg:nth-child(2) {
                display: none;
            }

            .loaded>span {
                display: inline-block;
            }

            .loaded>svg {
                display: none;
            }

            .loading {
                background: var(--active-btn) !important;
            }

            .loading>span {
                display: none;
            }

            .loading>svg {
                display: block;
            }

            .switch-slide {
                display: inline-block;
                vertical-align: middle;
            }

            .switch-slide-label {
                display: block;
                width: 38px;
                height: 18px;
                background: var(--text-color);
                border-radius: 30px;
                cursor: pointer;
                position: relative;
                -webkit-transition: all 250ms;
                transition: all 250ms;
            }

            .switch-slide-label:after {
                content: "";
                display: block;
                width: 16px;
                height: 16px;
                border-radius: 100%;
                background: #fff;
                box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
                position: absolute;
                left: 1px;
                top: 1px;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                -webkit-transition: all 250ms;
                transition: all 250ms;
            }

            .switch-slide input:checked+label {
                background: #99c959;
                -webkit-transition: all 250ms;
                transition: all 250ms;
            }

            .switch-slide input:checked+label:after {
                left: 21px;
            }

            .settings {
                margin-right: 10px;
                display: flex;
                position: absolute;
                right: 0;
                top: 5px;
            }

            .setBtn {
                margin-left: 2px;
                cursor: pointer;
                padding: 5px;
                border: none;
                background-color: transparent;
                border-radius: 4px;
            }

            .setBtn>svg {
                display: block;
                color: var(--text-color);
            }

            .setBtn:hover {
                background: var(--active-btn);
            }

            #setting {
                right: 15px;
            }

            #toggleFull {
                right: 56px;
            }

            #toggleLight *,
            #toggleFull * {
                pointer-events: none;
            }

            .showSetting {
                background: var(--lighter-svg-color) !important;
            }

            #setDialog {
                color: var(--btn-color);
                position: absolute;
                z-index: 2;
                background: var(--main-back);
                width: 320px;
                right: 6px;
                top: 46px;
                overflow-y: auto;
                max-height: calc(100% - 55px);
                -webkit-user-select: none;
                user-select: none;
                border-radius: 5px;
                padding: 8px 12px 8px 12px;
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
            }

            #setDialog input {
                width: 100%;
            }

            #setDialog .inlineTitle {
                display: inline-block;
                width: 88px;
                line-height: 16px;
                vertical-align: middle;
            }

            #convOption,
            #speechOption,
            #speechDetail,
            #recOption {
                margin-bottom: 6px;
            }

            #convOption>div,
            #speechOption>div,
            #speechDetail>div,
            #recOption div {
                margin-top: 7px;
            }

            #voiceRecSetting select,
            #speechDetail select {
                background: var(--chat-back);
                color: var(--chat-text-color);
            }

            .inputTextClass {
                outline: none;
                border-radius: 2px;
                margin-top: 3px;
                height: 32px;
                font-size: 15px;
                padding-left: 6px;
                background: var(--chat-back);
                color: var(--chat-text-color);
                border: none;
            }

            .areaTextClass {
                width: 100%;
                height: 80px;
                display: block;
                resize: none;
                padding: 6px;
            }

            input[type="range"] {
                -webkit-appearance: none;
                appearance: none;
                display: block;
                margin: 4px 0 3px 0;
                height: 8px;
                background: var(--text-color);
                border-radius: 5px;
                background-image: linear-gradient(#99c959, #99c959);
                background-size: 100% 100%;
                background-repeat: no-repeat;
            }

            input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                height: 15px;
                width: 15px;
                border-radius: 50%;
                background: #99c959;
                cursor: ew-resize;
            }

            input[type=range]::-webkit-slider-runnable-track {
                -webkit-appearance: none;
                box-shadow: none;
                border: none;
                background: transparent;
            }

            .justSetLine {
                display: flex;
                justify-content: space-between;
            }

            .justSetBtn {
                height: 32px;
                border-radius: 3px;
                line-height: 32px;
                background: var(--lighter-active);
                text-align: center;
                padding: 0px 8px;
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: pointer;
            }

            .justSetBtn:hover {
                background-color: var(--sel-btn);
            }

            .justSetBtn>svg {
                margin-right: 3px;
            }

            .readyTestVoice>div:not(:first-child) {
                display: none;
            }

            .pauseTestVoice>div:nth-child(1),
            .pauseTestVoice>div:nth-child(3) {
                display: none;
            }

            .resumeTestVoice>div:nth-child(1),
            .resumeTestVoice>div:nth-child(2) {
                display: none;
            }

            .presetSelect>div {
                display: inline-block;
            }

            .presetSelect select {
                outline: none;
                border-radius: 3px;
                width: 128px;
                border-color: rgba(0, 0, 0, .3);
                background: var(--chat-back);
                color: var(--chat-text-color);
            }

            .selectDef {
                display: flex;
                justify-content: space-between;
                font-size: 13px;
                color: var(--text-color);
            }

            #preSetSpeech {
                width: 100%;
                outline: none;
                height: 30px;
                font-size: 14px;
                margin-top: 5px;
                border-radius: 3px;
                border-color: rgba(0, 0, 0, .3);
            }

            .mdOption {
                flex-shrink: 0;
                position: relative;
                width: 30px;
                pointer-events: none;
            }

            .mdOption>div {
                pointer-events: auto;
                cursor: pointer;
            }

            .mdOption svg * {
                pointer-events: none;
            }

            .refreshReq svg:not(:first-child) {
                display: none;
            }

            .halfRefReq svg:not(:nth-child(2)) {
                display: none;
            }

            .optionItems {
                position: absolute;
                bottom: -12px;
                display: flex;
                justify-content: space-between;
                visibility: hidden;
                z-index: 1;
                color: var(--svg-color);
            }

            .optionItems:hover {
                visibility: visible;
            }

            .request:hover .optionItems,
            .request:hover .voiceCls,
            .response:hover .optionItems,
            .response:hover .voiceCls {
                visibility: visible;
            }

            .optionItem {
                border-radius: 10px;
                height: 24px;
                width: 32px;
                border: 1px solid var(--active-btn);
                background-color: var(--response-color);
                display: flex !important;
                justify-content: center;
                align-items: center;
            }

            .optionItem * {
                pointer-events: none;
            }

            .optionItem:hover {
                background: var(--active-btn);
            }

            .voiceCls {
                position: relative;
                height: 100%;
                visibility: hidden;
                display: flex;
                align-items: center;
            }

            .voiceCls>svg {
                color: var(--lighter-svg-color);
                display: block;
                margin-left: 5px;
                position: relative;
            }

            .voiceCls:hover>svg {
                color: var(--svg-color);
            }

            .showVoiceCls,
            .showVoiceCls .markdown-body {
                background: var(--active-btn) !important;
            }

            .showVoiceCls .voiceCls {
                visibility: visible !important;
            }

            .showEditReq {
                position: sticky !important;
                top: 0;
                bottom: 0;
                z-index: 1;
            }

            .showEditReq,
            .showEditReq .markdown-body {
                background: var(--active-btn) !important;
            }

            .readyVoice svg:not(:first-child) {
                display: none;
            }

            .pauseVoice svg:not(:nth-child(2)) {
                display: none;
            }

            .resumeVoice svg:not(:nth-child(3)) {
                display: none;
            }

            #voiceTypes>span {
                border-radius: 3px;
                margin-left: 4px;
                cursor: pointer;
                padding: 1px 5px;
            }

            #voiceTypes>span:hover {
                background: var(--active-btn);
            }

            .selVoiceType {
                background: var(--sel-btn) !important;
            }

            .navHeader {
                width: 100%;
                padding: 5px 10px;
                display: flex;
                justify-content: space-between;
            }

            #newChat {
                text-align: center;
                width: 80%;
                height: 40px;
                border-radius: 3px;
                background: var(--lighter-active-color);
                color: var(--btn-color);
                display: flex;
                align-items: center;
                justify-content: center;
                -webkit-user-select: none;
                user-select: none;
                cursor: pointer;
                flex: 1;
            }

            .navHeader>div:hover {
                background: var(--active-btn) !important;
            }

            #newChat>svg {
                margin-right: 2px;
            }

            #newFolder {
                height: 40px;
                width: 40px;
                margin-left: 10px;
                border-radius: 3px;
                color: var(--btn-color);
                cursor: pointer;
                position: relative;
                background: var(--lighter-active-color);
                -webkit-user-select: none;
                user-select: none;
            }

            #newFolder>svg {
                display: block;
                margin: 8px auto;
            }

            .extraChat {
                padding: 2px 10px 6px 10px;
                position: relative;
            }

            #searchChat {
                width: 100%;
                height: 36px;
                padding-left: 10px;
                padding-right: 45px;
                font-size: 16px;
                outline: none;
                border: none;
                color: var(--chat-text-color);
                background: var(--lighter-active-color);
                border-radius: 3px;
            }

            #searchChat:focus {
                background: var(--active-btn)
            }

            #searchChat:placeholder-shown+#clearSearch {
                display: none;
            }

            #clearSearch {
                position: absolute;
                right: 34px;
                top: 8px;
                cursor: pointer;
                color: var(--btn-color);
            }

            #clearSearch:hover {
                color: var(--black-color);
            }

            #clearSearch>svg {
                display: block;
            }

            .seledSearch {
                background: var(--lighter-svg-color) !important;
            }

            #matchCaseSearch {
                position: absolute;
                right: 12px;
                top: 8px;
                cursor: pointer;
                border-radius: 3px;
                color: var(--btn-color);
            }

            #matchCaseSearch:hover {
                background: var(--sel-btn);
            }

            #matchCaseSearch>svg {
                display: block;
            }

            .navFooter {
                padding-bottom: 8px;
            }

            .navFooter .divider {
                width: 100%;
                border-top: 1px solid var(--active-btn);
                margin: 4px 0;
            }

            .navFunc {
                padding-top: 5px;
                display: flex;
                justify-content: space-around;
            }

            .navFunc svg {
                display: block;
            }

            .navFunc>div,
            .navFunc>label {
                border-radius: 20px;
                text-align: center;
                padding: 8px 8px;
                color: var(--btn-color);
                font-size: 14px;
                cursor: pointer;
            }

            .navFunc>div:hover,
            .navFunc>label:hover {
                background: var(--active-btn);
            }

            .navFooter .links {
                text-align: center;
            }

            .navFooter .links a {
                color: var(--btn-color);
                text-decoration: none;
            }

            .navFooter .links a:hover {
                color: var(--chat-text-color) !important;
            }

            .navFooter .links a:visited {
                color: var(--btn-color);
            }

            .allList {
                width: 100%;
                position: relative;
                flex: 1;
                overflow-y: auto;
            }

            #chatList {
                min-height: 50px;
            }

            .dragingLi {
                filter: brightness(90%);
            }

            .dragingChat {
                background: var(--lighter-active-color);
            }

            .expandFolder>.headLi>svg {
                transform: rotate(90deg);
            }

            .expandFolder>.chatsInFolder {
                display: block;
            }

            .chatsInFolder {
                display: none;
                margin-left: 22px;
                padding-left: 2px;
                border-left: 1px solid var(--text-color);
            }

            .headLi,
            .chatLi {
                cursor: pointer;
                width: 100%;
                height: 50px;
                color: var(--text-color);
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: relative;
            }

            .headLi *,
            .chatLi * {
                pointer-events: none;
            }

            .headLi>svg,
            .chatLi>svg {
                margin-left: 10px;
                color: var(--btn-color);
                pointer-events: none;
            }

            .folderOption svg,
            .chatOption svg {
                pointer-events: auto;
            }

            .headLi svg *,
            .chatLi svg * {
                pointer-events: none;
            }

            .headLi .folderInfo {
                position: absolute;
                left: 40px;
                height: 40px;
                max-width: calc(100% - 115px);
            }

            .chatLi .chatInfo {
                position: absolute;
                left: 40px;
                height: 40px;
                max-width: calc(100% - 90px);
            }

            .folderInfo *,
            .chatInfo * {
                -webkit-user-select: none;
                user-select: none;
            }

            .chatInfo span {
                background: #f8b26a;
            }

            .headLi .folderName,
            .chatLi .chatName {
                color: var(--btn-color);
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
                line-height: 20px;
                height: 20px;
            }

            .headLi .folderNum,
            .chatLi .chatPre {
                color: var(--btn-color);
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
                font-size: 12px;
                line-height: 20px;
                height: 20px;
            }

            .headLi .folderOption,
            .chatLi .chatOption {
                visibility: hidden;
                display: flex;
                color: #777;
                margin-right: 2px;
            }

            .folderLi .chatLi>svg {
                margin-left: 5px;
            }

            .folderLi .chatLi .chatInfo {
                left: 35px;
                max-width: calc(100% - 85px);
            }

            .folderLi .chatLi #activeChatEdit {
                left: 32px;
                width: calc(100% - 60px)
            }

            .folderLi:hover {
                background: var(--lighter-active);
            }

            .chatLi:hover {
                background: var(--active-btn);
            }

            .headLi:hover .folderOption,
            .chatLi:hover .chatOption {
                visibility: visible !important;
            }

            .activeFolder,
            .activeChatLi {
                background: var(--sel-btn) !important;
            }

            .activeChatLi .chatOption {
                visibility: visible !important;
            }

            .folderOption>svg:hover,
            .chatOption>svg:hover {
                color: #444;
            }

            #activeChatEdit {
                position: absolute;
                left: 37px;
                font-size: 16px;
                border-radius: 2px;
                color: var(--chat-text-color);
                background: var(--chat-back);
                outline: none;
                border: none;
                pointer-events: auto;
                height: 24px;
                line-height: 24px;
                width: calc(100% - 65px);
                padding: 20px 3px;
                z-index: 1;
            }

            #loadMask {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 100;
                background-color: var(--background);
            }

            #loadMask>div {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }

            @keyframes loading {

                0%,
                100% {
                    transform: scale(0);
                }

                50% {
                    transform: scale(1);
                }
            }

            .loadingCSSIcon {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: space-evenly;
            }

            .loadingCSSIcon div {
                width: 15%;
                height: 0;
                padding-bottom: 15%;
                border-radius: 50%;
                animation: loading 1s cubic-bezier(0.3, 0, 0.7, 1) infinite;
            }

            .loadingCSSIcon div:nth-child(1) {
                background: #e15b64;
                animation-delay: -0.4s
            }

            .loadingCSSIcon div:nth-child(2) {
                background: #f8b26a;
                animation-delay: -0.2s
            }

            .loadingCSSIcon div:nth-child(3) {
                background: #99c959;
                animation-delay: 0s;
            }

            #loadMask>div>:first-child {
                font-size: 40px;
                color: var(--text-color);
            }

            #loadMask>div>:last-child {
                width: 140px;
                height: 70px;
                margin: 0 auto;
            }

            #voiceRec {
                position: absolute;
                right: 0;
                top: 0;
                width: 47px;
                height: 100%;
            }

            .message_if_voice {
                padding-right: 47px !important;
            }

            #voiceRecIcon {
                width: 100%;
                height: 100%;
                text-align: center;
                cursor: pointer;
                position: relative;
            }

            #voiceRecIcon:hover>svg {
                color: var(--svg-color);
            }

            #voiceRecIcon>svg {
                width: 25px;
                height: 25px;
                color: #b0b0b0;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -12px;
                margin-left: -13px;
            }

            #voiceRecIcon>svg .animVoice {
                display: none;
            }

            .voiceRecing>svg {
                color: #99c959 !important;
            }

            .voiceRecing .animVoice {
                display: inline !important;
                transform-origin: 0 64%;
                animation-duration: 1.5s;
                animation-name: scaleVoice;
                animation-timing-function: ease;
                animation-iteration-count: infinite;
            }

            .voiceLong .animVoice {
                display: inline !important;
                transform-origin: 0 64%;
                animation-duration: 0.3s;
                animation-name: longVoice;
                animation-timing-function: ease-in-out;
                animation-iteration-count: 1;
            }

            @keyframes longVoice {
                0% {
                    transform: scaleY(0);
                }

                100% {
                    transform: scaleY(1);
                }
            }

            @keyframes scaleVoice {
                0% {
                    transform: scaleY(0.28);
                }

                20% {
                    transform: scaleY(0.60);
                }

                28% {
                    transform: scaleY(0.28);
                }

                36% {
                    transform: scaleY(0.45);
                }

                44% {
                    transform: scaleY(0.28);
                }

                52% {
                    transform: scaleY(0.45);
                }

                62% {
                    transform: scaleY(0.80);
                }

                72% {
                    transform: scaleY(0.80);
                }

                90% {
                    transform: scaleY(0.28);
                }

                100% {
                    transform: scaleY(0.28);
                }
            }

            #voiceRecSetting {
                display: none;
                position: absolute;
                top: -70px;
                left: -26px;
                z-index: 1;
                padding: 4px 4px;
                -webkit-user-select: none;
                user-select: none;
                border-radius: 3px;
                background-color: var(--main-back);
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
            }

            #voiceRecSetting select {
                width: 102px;
                outline: none;
                height: 28px;
                border-radius: 3px;
                border-color: rgba(0, 0, 0, .3);
            }

            .presetModelCls label {
                margin-right: 8px;
            }

            .presetModelCls select {
                height: 30px;
                margin-top: 2px;
                font-size: 15px;
            }

            .setSwitch {
                display: flex;
            }

            .setSwitch>div {
                border-radius: 3px;
                width: calc(100% / 3);
                height: 32px;
                line-height: 32px;
                text-align: center;
                cursor: pointer;
            }

            .setSwitch>div:hover {
                background-color: var(--active-btn);
            }

            .activeSwitch {
                background-color: var(--sel-btn) !important;
            }

            #checkVoiceLoad {
                height: 32px;
                border-radius: 3px;
                line-height: 32px;
                background: var(--sel-btn);
                text-align: center;
                display: flex;
                justify-content: center;
                cursor: pointer;
            }

            #checkVoiceLoad:hover {
                background: var(--lighter-svg-color);
            }

            .voiceChecking {
                background-color: var(--lighter-svg-color) !important;
            }

            .voiceChecking>svg {
                display: inline !important;
            }

            #checkVoiceLoad>svg {
                display: none;
                margin-right: 8px;
                height: 32px;
                width: 64px;
            }

            #preSetSystem {
                height: 20px;
                line-height: 20px;
                vertical-align: top;
            }

            #sysMask {
                display: none;
                position: fixed;
                z-index: 200;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                cursor: pointer;
                justify-content: center;
                align-items: center;
                background: rgba(0, 0, 0, .4);
                -webkit-tap-highlight-color: transparent;
            }

            #sysDialog {
                position: relative;
                background: var(--chat-back);
                color: var(--btn-color);
                cursor: auto;
                max-height: 100%;
                width: 88%;
                display: flex;
                flex-direction: column;
                border-radius: 4px;
                padding: 12px 20px 12px 20px;
            }

            .sysTitle {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 8px;
                -webkit-user-select: none;
                user-select: none;
            }

            .sysSwitch,
            .sysSwitch>div * {
                pointer-events: none;
            }

            .sysSwitch>div {
                border-radius: 3px;
                height: 32px;
                line-height: 32px;
                text-align: center;
                cursor: pointer;
                pointer-events: auto;
                font-weight: bold;
                display: flex;
                align-items: center;
                -webkit-user-select: none;
                user-select: none;
            }

            .sysSwitch>div>svg {
                margin-right: 4px;
            }

            .sysSwitch>div:hover {
                background-color: var(--active-btn);
            }

            .sysDetail {
                overflow-y: auto;
                flex: 1;
            }

            #closeSet {
                position: absolute;
                right: 0px;
                top: 0px;
                cursor: pointer;
                padding: 10px 14px;
            }

            #closeSet:hover {
                color: var(--black-color);
            }

            .setContent {
                margin-bottom: 10px;
            }

            .setNotNormalFlow {
                position: absolute;
            }

            .setTitle {
                margin-bottom: 6px;
                font-weight: bold;
                -webkit-user-select: none;
                user-select: none;
            }

            .setDetail {
                margin: 0 10px;
                -webkit-user-select: none;
                user-select: none;
            }

            .autoSelect>label,
            .autoSelect>input {
                cursor: pointer;
            }

            .dataDetail {
                display: flex;
            }

            .dataDetail svg {
                margin-right: 4px;
            }

            .dataDetail>div,
            .dataDetail>label {
                border-radius: 3px;
                text-align: center;
                padding: 6px 8px;
                margin-right: 12px;
                color: var(--btn-color);
                font-size: 15px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .dataDetail>div:hover,
            .dataDetail>label:hover {
                background: var(--lighter-active-color);
            }

            .keyOptionDetail {
                display: flex;
                margin-top: 10px;
            }

            #resetHotKey {
                display: flex;
                align-items: center;
                justify-content: space-between;
                cursor: pointer;
                font-size: 15px;
                color: var(--btn-color);
                border-radius: 3px;
                padding: 6px 8px;
                margin-left: 90px;
            }

            #resetHotKey>svg {
                margin-right: 4px;
            }

            #resetHotKey:hover {
                background: var(--lighter-active-color);
            }

            .hotKeyDetail>div {
                position: relative;
                height: 30px;
                margin-bottom: 2px;
            }

            .hotKeyDetail label {
                line-height: 30px;
            }

            .hotKeyDetail select {
                position: absolute;
                left: 110px;
                outline: none;
                border-radius: 3px;
                width: 120px;
                border-color: rgba(0, 0, 0, .3);
                background: var(--chat-back);
                color: var(--chat-text-color);
                height: 30px;
                font-size: 15px;
            }

            .avatarDetail {
                display: flex;
                margin-top: 2px;
            }

            .avatarDetail img {
                border-radius: 2px;
                width: 32px;
                height: 32px;
                flex-shrink: 0;
                margin-right: 8px;
                margin-top: 2px;
            }

            .inputDetail input {
                outline: none;
                border-radius: 3px;
                padding-left: 8px;
                font-size: 15px;
                width: 100%;
                height: 34px;
                border: 1px solid rgba(0, 0, 0, .3);
                background: var(--chat-back);
                color: var(--chat-text-color);
            }

            .apiDetail {
                display: flex;
            }

            .apiDetail input {
                flex: 1;
            }

            .apiDetail>div {
                margin-left: 6px;
                background: var(--lighter-active-color);
                border-radius: 3px;
                width: 108px;
                text-align: center;
                cursor: pointer;
                margin-top: 2px;
                height: 34px;
                line-height: 34px;
                font-size: 15px;
            }

            .apiDetail>div:hover {
                background: var(--active-btn);
            }

            .themeDetail {
                display: flex;
                width: 180px;
                justify-content: space-between;
                pointer-events: none;
            }

            .themeDetail svg {
                display: block;
            }

            .themeDetail>div {
                pointer-events: auto;
                border-radius: 20px;
                text-align: center;
                padding: 8px 8px;
                color: var(--btn-color);
                font-size: 14px;
                cursor: pointer;
            }

            .themeDetail>div * {
                pointer-events: none;
            }

            .themeDetail>div:hover {
                background: var(--lighter-active-color);
            }

            .darkTheme>div:first-child {
                background: var(--sel-btn);
            }

            .lightTheme>div:nth-child(2) {
                background: var(--sel-btn);
            }

            .autoTheme>div:nth-child(3) {
                background: var(--sel-btn);
            }

            .langDetail {
                width: 110px;
            }

            .enLang>div:first-child {
                background: var(--sel-btn);
            }

            .zhLang>div:nth-child(2) {
                background: var(--sel-btn);
            }

            #customAutoSet input {
                width: 100px;
                height: 30px;
                line-height: 30px;
                font-size: 15px;
                outline: none;
                border: 1px solid rgba(0, 0, 0, .3);
                text-align: center;
                border-radius: 3px;
                background: var(--chat-back);
                color: var(--chat-text-color);
            }

            #customAutoSet label {
                margin-right: 8px;
            }

            .progressBar {
                position: relative;
                width: 100%;
                height: 12px;
                border-radius: 6px;
                background: var(--active-btn);
                overflow: hidden;
            }

            .nowProgress {
                position: absolute;
                left: 0;
                top: 0;
                height: 12px;
                min-width: 1px;
                border-radius: 6px;
                background: #99c959;
            }

            .progressDetail {
                display: flex;
                justify-content: space-between;
                font-size: 15px;
            }

            .cursorCls {
                background: var(--chat-text-color);
                width: 4px;
                animation: 1s cursor-blinker infinite step-start;
            }

            @keyframes cursor-blinker {
                0% {
                    opacity: 0;
                }

                50% {
                    opacity: 1;
                }

                100% {
                    opacity: 0;
                }
            }

            #apiSelect {
                position: absolute;
                top: 37px;
                padding: 4px 0;
                background: var(--chat-back);
                width: 100%;
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
                max-height: 180px;
                overflow-y: auto;
                -webkit-user-select: none;
                user-select: none;
            }

            #apiSelect>div {
                pointer-events: auto;
                cursor: pointer;
                font-size: 15px;
                padding: 6px 0 6px 8px;
                height: 36px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            #apiSelect>div:hover {
                background: var(--lighter-active-color);
            }

            #apiSelect>div>span {
                height: 100%;
                line-height: 23px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }

            #apiSelect>div * {
                pointer-events: none;
            }

            .delApiOption:hover {
                background: var(--lighter-svg-color);
            }

            .delApiOption {
                width: 36px;
                height: 36px;
                flex-shrink: 0;
                pointer-events: auto !important;
            }

            .delApiOption>svg {
                margin: 6px;
                display: block;
            }
        </style>
        <style>
            /* for katex */
            .katex {
                font-size: 1em !important;
            }

            eq {
                display: inline-block;
            }

            eqn {
                display: block
            }

            section.eqno {
                display: flex;
                flex-direction: row;
                align-content: space-between;
                align-items: center;
            }

            section.eqno>eqn {
                width: 100%;
                margin-left: 3em;
            }

            section.eqno>span {
                width: 3em;
                text-align: right;
            }
        </style>
        <script>
            let themeMode; // 2: 自动， 1: 浅色，0: 深色
            let autoThemeMode; // 1: 跟随系统，0:自定义时间
            let customDarkTime; // 开始，结束时间
            let isFull = false; // 是否全屏
            const darkMedia = window.matchMedia("(prefers-color-scheme: dark)");
            const justDarkTheme = (is) => {
                if (is) document.documentElement.setAttribute("data-theme", "dark");
                else document.documentElement.removeAttribute("data-theme");
                document.head.children[4].content = document.head.children[5].content = document.head.children[6].content = getComputedStyle(document.documentElement).getPropertyValue("--background");
            }
            const checkDark = () => {
                const checkCustomTheme = () => {
                    let date = new Date();
                    let nowTime = date.getTime();
                    let start = customDarkTime[0].split(":");
                    let startTime = new Date().setHours(start[0], start[1], 0, 0);
                    let end = customDarkTime[1].split(":");
                    let endTime = new Date().setHours(end[0], end[1], 0, 0);
                    let order = endTime > startTime;
                    let isDark = order ? (nowTime > startTime && endTime > nowTime) : !(nowTime > endTime && startTime > nowTime);
                    justDarkTheme(isDark);
                }
                const setDarkMode = () => {
                    if (themeMode === 2) {
                        if (autoThemeMode) {
                            justDarkTheme(darkMedia.matches);
                        } else {
                            checkCustomTheme();
                        }
                    } else if (themeMode === 1) {
                        justDarkTheme(false);
                    } else {
                        justDarkTheme(true);
                    }
                    localStorage.setItem("themeMode", themeMode);
                }
                let localTheme = localStorage.getItem("themeMode");
                themeMode = parseInt(localTheme || "1");
                let localAutoTheme = localStorage.getItem("autoThemeMode");
                autoThemeMode = parseInt(localAutoTheme || "1");
                let localCustomDark = localStorage.getItem("customDarkTime");
                customDarkTime = JSON.parse(localCustomDark || '["21:00", "07:00"]');
                setDarkMode();
            }
            checkDark();
        </script>
    </head>

    <body>
        <div style="display: none">
            <svg>
                <symbol viewBox="0 0 24 24" id="optionIcon">
                    <path fill="currentColor" d="M12 3c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 14c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-7c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="refreshIcon">
                    <path fill="currentColor" d="M18.537 19.567A9.961 9.961 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10c0 2.136-.67 4.116-1.81 5.74L17 12h3a8 8 0 1 0-2.46 5.772l.997 1.795z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="halfRefIcon">
                    <path fill="currentColor" d="M 4.009 12.163 C 4.012 12.206 2.02 12.329 2 12.098 C 2 6.575 6.477 2 12 2 C 17.523 2 22 6.477 22 12 C 22 14.136 21.33 16.116 20.19 17.74 L 17 12 L 20 12 C 19.999 5.842 13.333 1.993 7.999 5.073 C 3.211 8.343 4.374 12.389 4.009 12.163 Z" />
                </symbol>
                <symbol viewBox="-2 -2 20 20" id="copyIcon">
                    <path fill="currentColor" d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z">
                    </path>
                    <path fill="currentColor" d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="delIcon">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7v0a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v0M9 7h6M9 7H6m9 0h3m2 0h-2M4 7h2m0 0v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="readyVoiceIcon">
                    <path fill="currentColor" d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 20 20" id="pauseVoiceIcon">
                    <path stroke="currentColor" stroke-width="2.4" d="M6 3v14M14 3v14"></path>
                </symbol>
                <symbol viewBox="0 0 16 16" id="resumeVoiceIcon">
                    <path fill="currentColor" d="M4 3L4 13L12 8Z"></path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="stopResIcon">
                    <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16zM9 9h6v6H9V9z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 128 128" id="downAudioIcon">
                    <path d="M 64.662 1.549 C 56.549 4.524, 46.998 14.179, 45.523 20.895 C 45.041 23.089, 44.073 23.833, 40.433 24.807 C 34.752 26.326, 27.956 32.929, 25.527 39.289 C 24.273 42.574, 23.884 45.715, 24.196 50.034 C 24.620 55.897, 24.528 56.193, 21.836 57.585 C 17.142 60.012, 16 63.617, 16 76 C 16 88.463, 17.137 91.985, 21.967 94.483 C 28.244 97.729, 36.120 95.350, 38.579 89.466 C 39.387 87.532, 40 82.764, 40 78.415 C 40 70.971, 40.060 70.783, 42.250 71.370 C 43.487 71.701, 48.888 71.979, 54.250 71.986 L 64 72 64 76 L 64 80 57.122 80 C 49.420 80, 48.614 80.543, 47.547 86.453 C 46.552 91.964, 43.550 97.473, 40.273 99.803 C 33 104.974, 23.120 105.042, 16.118 99.971 C 11.407 96.558, 9.048 92.484, 8.145 86.205 C 6.963 77.979, 0.794 77.729, 0.191 85.883 C -0.196 91.111, 3.323 99.170, 8.062 103.908 C 11.290 107.136, 20.073 111.969, 22.750 111.990 C 23.540 111.996, 24 113.472, 24 116 C 24 119.740, 23.813 120, 21.122 120 C 17.674 120, 15.727 122.044, 16.173 125.195 C 16.492 127.441, 16.781 127.500, 27.391 127.500 C 36.676 127.500, 38.445 127.242, 39.386 125.750 C 40.993 123.203, 38.986 120.568, 35.149 120.187 C 32.206 119.894, 32 119.617, 32 115.956 C 32 112.509, 32.330 111.959, 34.750 111.377 C 42.181 109.591, 52.157 101.208, 53.575 95.559 C 53.928 94.152, 54.514 93, 54.878 93 C 55.242 93, 59.797 97.275, 65 102.500 C 70.762 108.286, 75.256 112, 76.495 112 C 77.769 112, 83.287 107.231, 91.264 99.236 C 101.113 89.366, 104 85.876, 104 83.843 C 104 80.580, 102.553 80, 94.418 80 L 88 80 88 76.105 L 88 72.211 99.750 71.815 C 113.117 71.364, 117.595 69.741, 122.762 63.473 C 128.159 56.925, 129.673 45.269, 126.134 37.500 C 123.787 32.346, 117.218 26.445, 112.132 24.921 C 108.617 23.868, 107.767 22.968, 105.028 17.405 C 99.364 5.901, 89.280 -0.062, 75.712 0.070 C 71.746 0.109, 66.773 0.774, 64.662 1.549 M 67.885 9.380 C 60.093 12.164, 55.057 17.704, 52.527 26.276 C 51.174 30.856, 50.220 31.617, 44.729 32.496 C 37.017 33.729, 30.917 42.446, 32.374 50.154 C 34.239 60.026, 40.582 63.944, 54.750 63.978 L 64 64 64 57.122 C 64 52.457, 64.449 49.872, 65.396 49.086 C 66.310 48.328, 70.370 48.027, 77.146 48.214 L 87.500 48.500 87.794 56.359 L 88.088 64.218 98.989 63.845 C 108.043 63.535, 110.356 63.125, 112.634 61.424 C 119.736 56.122, 121.911 47.667, 118.097 40.190 C 115.870 35.824, 110.154 32.014, 105.790 31.985 C 102.250 31.961, 101.126 30.787, 99.532 25.443 C 95.580 12.197, 80.880 4.736, 67.885 9.380 M 72 70.800 C 72 80.978, 71.625 85.975, 70.800 86.800 C 70.140 87.460, 67.781 88, 65.559 88 L 61.517 88 68.759 95.241 L 76 102.483 83.241 95.241 L 90.483 88 86.441 88 C 84.219 88, 81.860 87.460, 81.200 86.800 C 80.375 85.975, 80 80.978, 80 70.800 L 80 56 76 56 L 72 56 72 70.800 M 25.200 65.200 C 23.566 66.834, 23.566 85.166, 25.200 86.800 C 27.002 88.602, 29.798 88.246, 30.965 86.066 C 31.534 85.002, 32 80.472, 32 76 C 32 71.528, 31.534 66.998, 30.965 65.934 C 29.798 63.754, 27.002 63.398, 25.200 65.200" stroke="none" fill="currentColor" fill-rule="evenodd" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="chatIcon">
                    <path fill="currentColor" d="m18 21l-1.4-1.4l1.575-1.6H14v-2h4.175L16.6 14.4L18 13l4 4l-4 4ZM3 21V6q0-.825.588-1.413T5 4h12q.825 0 1.413.588T19 6v5.075q-.25-.05-.5-.063T18 11q-.25 0-.5.013t-.5.062V6H5v10h7.075q-.05.25-.063.5T12 17q0 .25.013.5t.062.5H6l-3 3Zm4-11h8V8H7v2Zm0 4h5v-2H7v2Zm-2 2V6v10Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="chatEditIcon">
                    <path fill="currentColor" d="M5 19h1.4l8.625-8.625l-1.4-1.4L5 17.6V19ZM19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Zm-3.525-.725l-.7-.7l1.4 1.4l-.7-.7Z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="deleteIcon">
                    <path fill="currentColor" d="M8 20v-5h2v5h9v-7H5v7h3zm-4-9h16V8h-6V4h-4v4H4v3zM3 21v-8H2V7a1 1 0 0 1 1-1h5V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3h5a1 1 0 0 1 1 1v6h-1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="addIcon" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </symbol>
                <symbol viewBox="0 0 200 100" preserveAspectRatio="xMidYMid" id="loadingIcon">
                    <g transform="translate(50 50)">
                        <circle cx="0" cy="0" r="15" fill="#e15b64">
                            <animateTransform attributeName="transform" type="scale" begin="-0.4s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                        </circle>
                    </g>
                    <g transform="translate(100 50)">
                        <circle cx="0" cy="0" r="15" fill="#f8b26a">
                            <animateTransform attributeName="transform" type="scale" begin="-0.2s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                        </circle>
                    </g>
                    <g transform="translate(150 50)">
                        <circle cx="0" cy="0" r="15" fill="#99c959">
                            <animateTransform attributeName="transform" type="scale" begin="0s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                        </circle>
                    </g>
                </symbol>
                <symbol viewBox="0 0 24 24" id="exportIcon">
                    <path fill="currentColor" d="m17.86 18l1.04 1c-1.4 1.2-3.96 2-6.9 2c-4.41 0-8-1.79-8-4V7c0-2.21 3.58-4 8-4c2.95 0 5.5.8 6.9 2l-1.04 1l-.36.4C16.65 5.77 14.78 5 12 5C8.13 5 6 6.5 6 7s2.13 2 6 2c1.37 0 2.5-.19 3.42-.46l.96.96H13.5v1.42c-.5.05-1 .08-1.5.08c-2.39 0-4.53-.53-6-1.36v2.81C7.3 13.4 9.58 14 12 14c.5 0 1-.03 1.5-.08v.58h2.88l-1 1l.12.11c-1.09.25-2.26.39-3.5.39c-2.28 0-4.39-.45-6-1.23V17c0 .5 2.13 2 6 2c2.78 0 4.65-.77 5.5-1.39l.36.39m1.06-10.92L17.5 8.5L20 11h-5v2h5l-2.5 2.5l1.42 1.42L23.84 12l-4.92-4.92Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="importIcon">
                    <path fill="currentColor" d="m8.84 12l-4.92 4.92L2.5 15.5L5 13H0v-2h5L2.5 8.5l1.42-1.42L8.84 12M12 3C8.59 3 5.68 4.07 4.53 5.57L5 6l1.03 1.07C6 7.05 6 7 6 7c0-.5 2.13-2 6-2s6 1.5 6 2s-2.13 2-6 2c-2.62 0-4.42-.69-5.32-1.28l3.12 3.12c.7.1 1.44.16 2.2.16c2.39 0 4.53-.53 6-1.36v2.81c-1.3.95-3.58 1.55-6 1.55c-.96 0-1.9-.1-2.76-.27l-1.65 1.64c1.32.4 2.82.63 4.41.63c2.28 0 4.39-.45 6-1.23V17c0 .5-2.13 2-6 2s-6-1.5-6-2v-.04L5 18l-.46.43C5.69 19.93 8.6 21 12 21c4.41 0 8-1.79 8-4V7c0-2.21-3.58-4-8-4Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="clearAllIcon">
                    <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16zm0-9.414l2.828-2.829l1.415 1.415L13.414 12l2.829 2.828l-1.415 1.415L12 13.414l-2.828 2.829l-1.415-1.415L10.586 12L7.757 9.172l1.415-1.415L12 10.586z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="collapseFullIcon">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m20 20l-5-5m0 0v4m0-4h4M4 20l5-5m0 0v4m0-4H5M20 4l-5 5m0 0V5m0 4h4M4 4l5 5m0 0V5m0 4H5" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="expandFullIcon">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9L4 4m0 0v4m0-4h4m7 5l5-5m0 0v4m0-4h-4M9 15l-5 5m0 0v-4m0 4h4m7-5l5 5m0 0v-4m0 4h-4" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="darkThemeIcon">
                    <path fill="currentColor" d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="lightThemeIcon">
                    <path fill="currentColor" d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="autoThemeIcon">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M9.173 14.83a4 4 0 1 1 5.657-5.657" />
                        <path d="m11.294 12.707l.174.247a7.5 7.5 0 0 0 8.845 2.492A9 9 0 0 1 5.642 18.36M3 12h1m8-9v1M5.6 5.6l.7.7M3 21L21 3" />
                    </g>
                </symbol>
                <symbol viewBox="0 0 24 24" id="newFolderIcon">
                    <path fill="currentColor" d="M14 16h2v-2h2v-2h-2v-2h-2v2h-2v2h2v2ZM2 20V4h8l2 2h10v14H2Zm2-2h16V8h-8.825l-2-2H4v12Zm0 0V6v12Z" />
                </symbol>
                <symbol viewBox="0 0 20 20" id="expandFolderIcon">
                    <path fill="currentColor" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z">
                    </path>
                </symbol>
                <symbol viewBox="0 0 24 24" id="closeIcon">
                    <path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6L6.4 19Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="settingIcon">
                    <path fill="currentColor" d="M13.85 22.25h-3.7c-.74 0-1.36-.54-1.45-1.27l-.27-1.89c-.27-.14-.53-.29-.79-.46l-1.8.72c-.7.26-1.47-.03-1.81-.65L2.2 15.53c-.35-.66-.2-1.44.36-1.88l1.53-1.19c-.01-.15-.02-.3-.02-.46 0-.15.01-.31.02-.46l-1.52-1.19c-.59-.45-.74-1.26-.37-1.88l1.85-3.19c.34-.62 1.11-.9 1.79-.63l1.81.73c.26-.17.52-.32.78-.46l.27-1.91c.09-.7.71-1.25 1.44-1.25h3.7c.74 0 1.36.54 1.45 1.27l.27 1.89c.27.14.53.29.79.46l1.8-.72c.71-.26 1.48.03 1.82.65l1.84 3.18c.36.66.2 1.44-.36 1.88l-1.52 1.19c.01.15.02.3.02.46s-.01.31-.02.46l1.52 1.19c.56.45.72 1.23.37 1.86l-1.86 3.22c-.34.62-1.11.9-1.8.63l-1.8-.72c-.26.17-.52.32-.78.46l-.27 1.91c-.1.68-.72 1.22-1.46 1.22zm-3.23-2h2.76l.37-2.55.53-.22c.44-.18.88-.44 1.34-.78l.45-.34 2.38.96 1.38-2.4-2.03-1.58.07-.56c.03-.26.06-.51.06-.78s-.03-.53-.06-.78l-.07-.56 2.03-1.58-1.39-2.4-2.39.96-.45-.35c-.42-.32-.87-.58-1.33-.77l-.52-.22-.37-2.55h-2.76l-.37 2.55-.53.21c-.44.19-.88.44-1.34.79l-.45.33-2.38-.95-1.39 2.39 2.03 1.58-.07.56a7 7 0 0 0-.06.79c0 .26.02.53.06.78l.07.56-2.03 1.58 1.38 2.4 2.39-.96.45.35c.43.33.86.58 1.33.77l.53.22.38 2.55z">
                    </path>
                    <circle fill="currentColor" cx="12" cy="12" r="3.5"></circle>
                </symbol>
                <symbol viewBox="298 299 1808 1808" id="aiIcon">
                    <path fill="white" d="M1107.3 299.1c-198 0-373.9 127.3-435.2 315.3C544.8 640.6 434.9 720.2 370.5 833c-99.3 171.4-76.6 386.9 56.4 533.8-41.1 123.1-27 257.7 38.6 369.2 98.7 172 297.3 260.2 491.6 219.2 86.1 97 209.8 152.3 339.6 151.8 198 0 373.9-127.3 435.3-315.3 127.5-26.3 237.2-105.9 301-218.5 99.9-171.4 77.2-386.9-55.8-533.9v-.6c41.1-123.1 27-257.8-38.6-369.8-98.7-171.4-297.3-259.6-491-218.6-86.6-96.8-210.5-151.8-340.3-151.2zm0 117.5-.6.6c79.7 0 156.3 27.5 217.6 78.4-2.5 1.2-7.4 4.3-11 6.1L952.8 709.3c-18.4 10.4-29.4 30-29.4 51.4V1248l-155.1-89.4V755.8c-.1-187.1 151.6-338.9 339-339.2zm434.2 141.9c121.6-.2 234 64.5 294.7 169.8 39.2 68.6 53.9 148.8 40.4 226.5-2.5-1.8-7.3-4.3-10.4-6.1l-360.4-208.2c-18.4-10.4-41-10.4-59.4 0L1024 984.2V805.4L1372.7 604c51.3-29.7 109.5-45.4 168.8-45.5zM650 743.5v427.9c0 21.4 11 40.4 29.4 51.4l421.7 243-155.7 90L597.2 1355c-162-93.8-217.4-300.9-123.8-462.8C513.1 823.6 575.5 771 650 743.5zm807.9 106 348.8 200.8c162.5 93.7 217.6 300.6 123.8 462.8l.6.6c-39.8 68.6-102.4 121.2-176.5 148.2v-428c0-21.4-11-41-29.4-51.4l-422.3-243.7 155-89.3zM1201.7 997l177.8 102.8v205.1l-177.8 102.8-177.8-102.8v-205.1L1201.7 997zm279.5 161.6 155.1 89.4v402.2c0 187.3-152 339.2-339 339.2v-.6c-79.1 0-156.3-27.6-217-78.4 2.5-1.2 8-4.3 11-6.1l360.4-207.5c18.4-10.4 30-30 29.4-51.4l.1-486.8zM1380 1421.9v178.8l-348.8 200.8c-162.5 93.1-369.6 38-463.4-123.7h.6c-39.8-68-54-148.8-40.5-226.5 2.5 1.8 7.4 4.3 10.4 6.1l360.4 208.2c18.4 10.4 41 10.4 59.4 0l421.9-243.7z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="importSetIcon">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 21l-8-4.5v-9L12 3l8 4.5V12m-8 0l8-4.5M12 12v9m0-9L4 7.5M22 18h-7m3-3l-3 3l3 3" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="exportSetIcon">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 21l-8-4.5v-9L12 3l8 4.5V12m-8 0l8-4.5M12 12v9m0-9L4 7.5M15 18h7m-3-3l3 3l-3 3" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="databaseIcon">
                    <path fill="currentColor" d="M12 3C7.58 3 4 4.79 4 7v10c0 2.21 3.59 4 8 4s8-1.79 8-4V7c0-2.21-3.58-4-8-4m6 14c0 .5-2.13 2-6 2s-6-1.5-6-2v-2.23c1.61.78 3.72 1.23 6 1.23s4.39-.45 6-1.23V17m0-4.55c-1.3.95-3.58 1.55-6 1.55s-4.7-.6-6-1.55V9.64c1.47.83 3.61 1.36 6 1.36s4.53-.53 6-1.36v2.81M12 9C8.13 9 6 7.5 6 7s2.13-2 6-2s6 1.5 6 2s-2.13 2-6 2Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="stopIcon">
                    <path fill="currentColor" d="M6 5h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="forceRefreshIcon">
                    <path fill="currentColor" d="M13.82 14H9.66c-.1-.66-.16-1.32-.16-2s.06-1.35.16-2h4.68c.09.65.16 1.32.16 2c0 .5-.04 1-.1 1.46c.6-.5 1.32-.89 2.1-1.14V12c0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2v.18c.7.17 1.35.45 1.95.82c.05-.32.05-.66.05-1c0-5.5-4.5-10-10-10C6.47 2 2 6.5 2 12s4.5 10 10 10c.34 0 .68 0 1-.05c-.41-.66-.71-1.4-.87-2.2c-.04.07-.08.14-.13.21c-.83-1.2-1.5-2.53-1.91-3.96h2.41c.31-.75.76-1.42 1.32-2m5.1-6h-2.95a15.65 15.65 0 0 0-1.38-3.56c1.84.63 3.37 1.9 4.33 3.56M12 4.03c.83 1.2 1.5 2.54 1.91 3.97h-3.82c.41-1.43 1.08-2.77 1.91-3.97M4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2s.06 1.34.14 2H4.26m.82 2H8c.35 1.25.8 2.45 1.4 3.56A8.008 8.008 0 0 1 5.08 16M8 8H5.08A7.923 7.923 0 0 1 9.4 4.44C8.8 5.55 8.35 6.75 8 8m12.83 7.67L22 14.5v4h-4l1.77-1.77A2.5 2.5 0 1 0 20 20h1.71A3.991 3.991 0 0 1 18 22.5c-2.21 0-4-1.79-4-4s1.79-4 4-4c1.11 0 2.11.45 2.83 1.17Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="hotkeyIcon">
                    <g fill="none">
                        <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z" />
                        <path fill="currentColor" d="M18 3a3 3 0 0 1 2.995 2.824L21 6v12a3 3 0 0 1-2.824 2.995L18 21H6a3 3 0 0 1-2.995-2.824L3 18V6a3 3 0 0 1 2.824-2.995L6 3h12Zm-2.707 13.708A2.99 2.99 0 0 1 14 17H5v1a1 1 0 0 0 1 1h11.586l-2.293-2.292ZM18 5h-1v9c0 .386-.073.755-.206 1.094l-.086.2L19 17.585V6a1 1 0 0 0-.883-.993L18 5Zm-3 0H6a1 1 0 0 0-.993.883L5 6v9h9a1 1 0 0 0 .993-.883L15 14V5ZM9 7a1 1 0 0 1 .993.883L10 8v.631l1.445-.963a1 1 0 0 1 1.203 1.594l-.093.07l-1.377.918l1.377.918a1 1 0 0 1-1.009 1.723l-.1-.059L10 11.868V12a1 1 0 0 1-1.993.117L8 12V8a1 1 0 0 1 1-1Z" />
                    </g>
                </symbol>
                <symbol viewBox="0 0 24 24" id="zhIcon">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                        <path stroke-linejoin="round" d="M5 8h14v7H5z" />
                        <path d="M12 4v17" />
                    </g>
                </symbol>
                <symbol viewBox="0 0 24 24" id="enIcon">
                    <path fill="currentColor" d="M14 10h2v.757a4.5 4.5 0 0 1 7 3.743V20h-2v-5.5c0-1.43-1.174-2.5-2.5-2.5S16 13.07 16 14.5V20h-2V10Zm-2-6v2H4v5h8v2H4v5h8v2H2V4h10Z" />
                </symbol>
                <symbol viewBox="0 0 24 24" id="caseIcon">
                    <path fill="currentColor" d="m3.975 17l3.75-10h1.8l3.75 10H11.55l-.9-2.55H6.6L5.7 17H3.975Zm3.15-4h3l-1.45-4.15h-.1L7.125 13Zm9.225 4.275q-1.225 0-1.925-.638t-.7-1.737q0-1.05.813-1.713t2.087-.662q.575 0 1.063.088t.837.287v-.35q0-.675-.462-1.075t-1.263-.4q-.525 0-.988.225t-.787.65l-1.075-.8q.475-.675 1.2-1.025t1.675-.35q1.55 0 2.375.738t.825 2.137v4.4H18.55v-.85h-.075q-.325.5-.875.788t-1.25.287Zm.25-1.25q.8 0 1.363-.563t.562-1.362q-.35-.2-.8-.3t-.825-.1q-.8 0-1.225.313t-.425.887q0 .5.375.813t.975.312Z" />
                </symbol>
            </svg>
        </div>
        <div id="loadMask">
            <div>
                <div>Chat with Yiming</div>
                <div class="loadingCSSIcon">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="chat_window">
            <div class="overlay"></div>
            <nav class="nav">
                <div class="navHeader">
                    <div id="newChat">
                        <svg width="24" height="24">
                            <use xlink:href="#addIcon" />
                        </svg>
                        <span data-i18n-key="newChat"></span>
                    </div>
                    <div id="newFolder" data-i18n-title="newFolder" title>
                        <svg width="24" height="24">
                            <use xlink:href="#newFolderIcon" />
                        </svg>
                    </div>
                </div>
                <div class="extraChat">
                    <input type="text" id="searchChat" autocomplete="off" data-i18n-place="search" placeholder />
                    <div id="clearSearch">
                        <svg width="24" height="24">
                            <use xlink:href="#closeIcon" />
                        </svg>
                    </div>
                    <div id="matchCaseSearch" data-i18n-title="matchCaseTip" title>
                        <svg width="24" height="24">
                            <use xlink:href="#caseIcon" />
                        </svg>
                    </div>
                </div>
                <div class="allList">
                    <div id="folderList"></div>
                    <div id="chatList"></div>
                </div>
                <div class="navFooter">
                    <div class="navFunc">
                        <div id="refreshPage" data-i18n-title="forceRe" title>
                            <svg width="24" height="24">
                                <use xlink:href="#forceRefreshIcon" />
                            </svg>
                        </div>
                        <div id="clearChat" data-i18n-title="clearAll" title>
                            <svg width="24" height="24">
                                <use xlink:href="#clearAllIcon" />
                            </svg>
                        </div>
                        <div id="toggleLight" data-i18n-theme title>
                            <svg width="24" height="24">
                                <use xlink:href="#lightThemeIcon" />
                            </svg>
                        </div>
                        <div id="sysSetting" data-i18n-title="setting" title>
                            <svg width="24" height="24">
                                <use xlink:href="#settingIcon" />
                            </svg>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="links">
                        <a href="https://yiming1234.com" target="_blank" rel="noopener noreferrer">Yiming小站</a>
                    </div>
                    <div class="divider"></div>
                    <div class="links">
                        <a href="https://blog.yiming1234.cn" target="_blank" rel="noopener noreferrer">Yiming博客</a>
                    </div>
                    <div class="divider"></div>
                </div>
            </nav>
            <div class="mainContent">
                <div class="top_menu">
                    <div class="toggler" data-i18n-title="nav" title>
                        <div class="button close"></div>
                        <div class="button minimize"></div>
                        <div class="button maximize"></div>
                    </div>
                    <div class="title"><span>Try ChatGPT</span></div>
                    <div class="settings">
                        <button class="setBtn" id="toggleFull" data-i18n-window title>
                            <svg width="30" height="30">
                                <use xlink:href="#expandFullIcon" />
                            </svg>
                        </button>
                        <button class="setBtn" id="setting">
                            <svg viewBox="0 0 100 100" width="30" height="30">
                                <title data-i18n-key="quickSet"></title>
                                <circle cx="50" cy="20" r="10" fill="#e15b64" />
                                <circle cx="50" cy="50" r="10" fill="#f8b26a" />
                                <circle cx="50" cy="80" r="10" fill="#99c959" />
                            </svg>
                        </button>
                    </div>
                    <div id="setDialog" style="display:none;">
                        <div class="setSwitch">
                            <div data-id="convOption" data-i18n-key="chat" class="activeSwitch"></div>
                            <div data-id="speechOption" data-i18n-key="tts"></div>
                            <div data-id="recOption" data-i18n-key="stt"></div>
                        </div>
                        <div id="convOption">
                            <div class="presetSelect presetModelCls">
                                <select id="preSetModel">
                                    <option value="gpt-3.5-turbo">GPT-3.5</option>
                                </select>
                            </div>
                            <div>
                                <div class="avatarDetail">
                                    <img id="setAvatarPre" src="" />
                                    <input class="inputTextClass" autocomplete="off" type="text" id="setAvatar" style="visibility: hidden;" />
                                </div>
                            </div>
                            <div>
                                <div class="justSetLine presetSelect">
                                    <div data-i18n-key="systemRole"></div>
                                    <div>
                                        <label for="preSetSystem" data-i18n-key="presetRole"></label>
                                        <select id="preSetSystem">
                                            <option value="default" data-i18n-key="default"></option>
                                            <option value="normal" data-i18n-key="assistant"></option>
                                            <option value="cat" data-i18n-key="cat"></option>
                                            <option value="emoji" data-i18n-key="emoji"></option>
                                            <option value="image" data-i18n-key="withImg"></option>
                                        </select>
                                    </div>
                                </div>
                                <textarea class="inputTextClass areaTextClass" autocomplete="off" data-i18n-place="assistantText" placeholder id="systemInput"></textarea>
                            </div>
                            <div>
                                <span data-i18n-key="nature"></span>
                                <input type="range" id="top_p" min="0" max="1" value="0.7" step="0.05" />
                                <div class="selectDef">
                                    <span data-i18n-key="natureNeg"></span>
                                    <span data-i18n-key="naturePos"></span>
                                </div>
                            </div>
                            <div>
                                <span data-i18n-key="quality"></span>
                                <input type="range" id="temp" min="0" max="2" value="1" step="0.05" />
                                <div class="selectDef">
                                    <span data-i18n-key="qualityNeg"></span>
                                    <span data-i18n-key="qualityPos"></span>
                                </div>
                            </div>
                            <div>
                                <span data-i18n-key="chatsWidth"></span>
                                <input type="range" id="convWidth" min="30" max="100" value="100" step="1" />
                                <div class="selectDef">
                                    <span>30%</span>
                                    <span>100%</span>
                                </div>
                            </div>
                            <div>
                                <span data-i18n-key="typeSpeed"></span>
                                <input type="range" id="textSpeed" min="0" max="100" value="88" step="1" />
                                <div class="selectDef">
                                    <span data-i18n-key="slow"></span>
                                    <span data-i18n-key="fast"></span>
                                </div>
                            </div>
                            <div>
                                <span><span data-i18n-key="continuousLen"></span>: <span id="contLenWrap"></span><span data-i18n-key="msgAbbr"></span></span>
                                <input type="range" id="contLength" min="0" max="50" value="25" step="1" />
                                <div class="selectDef">
                                    <span>0</span>
                                    <span>50</span>
                                </div>
                            </div>
                            <div>
                                <span class="inlineTitle" data-i18n-key="longReply"></span>
                                <label class="switch-slide">
                                    <input type="checkbox" id="enableLongReply" hidden />
                                    <label for="enableLongReply" class="switch-slide-label"></label>
                                </label>
                            </div>
                        </div>
                        <div id="speechOption" style="display: none;">
                            <div class="presetSelect presetModelCls">
                                <label for="preSetService" data-i18n-key="ttsService"></label>
                                <select id="preSetService">
                                    <option value="3" data-i18n-key="azureTTS"></option>
                                    <option selected value="2" data-i18n-key="edgeTTS"></option>
                                    <option value="1" data-i18n-key="systemTTS"></option>
                                </select>
                            </div>
                            <div class="presetSelect presetModelCls">
                                <label for="preSetAzureRegion" data-i18n-key="azureRegion"></label>
                                <select id="preSetAzureRegion">
                                </select>
                            </div>
                            <div>
                                <div>Azure Access Key</div>
                                <input class="inputTextClass" type="text" placeholder="Azure Key" id="azureKeyInput" autocomplete="off" style="-webkit-text-security: disc;" />
                            </div>
                            <div id="checkVoiceLoad" style="display: none;">
                                <svg>
                                    <use xlink:href="#loadingIcon" />
                                </svg>
                                <span data-i18n-key="loadVoice"></span>
                            </div>
                            <div id="speechDetail">
                                <div>
                                    <div class="justSetLine">
                                        <div data-i18n-key="voiceName"></div>
                                        <div id="voiceTypes">
                                            <span data-type="0" data-i18n-key="userVoice"></span>
                                            <span data-type="1" class="selVoiceType" data-i18n-key="replyVoice"></span>
                                        </div>
                                    </div>
                                    <select id="preSetSpeech">
                                    </select>
                                </div>
                                <div>
                                    <div class="justSetLine">
                                        <input class="inputTextClass" id="testVoiceText" data-i18n-value="TTSTest" value />
                                    </div>
                                    <div class="justSetLine readyTestVoice" id="testVoiceBtn" style="margin-top: 6px;">
                                        <div class="justSetBtn" onclick="startTestVoice()">
                                            <svg width="18" height="18">
                                                <use xlink:href="#readyVoiceIcon" />
                                            </svg>
                                            <span data-i18n-key="play"></span>
                                        </div>
                                        <div class="justSetBtn" onclick="pauseTestVoice()">
                                            <svg width="18" height="18">
                                                <use xlink:href="#pauseVoiceIcon" />
                                            </svg>
                                            <span data-i18n-key="pause"></span>
                                        </div>
                                        <div class="justSetBtn" onclick="resumeTestVoice()">
                                            <svg width="18" height="18">
                                                <use xlink:href="#resumeVoiceIcon" />
                                            </svg>
                                            <span data-i18n-key="resume"></span>
                                        </div>
                                        <div class="justSetBtn" style="margin-right: 130px" onclick="stopTestVoice()">
                                            <svg width="18" height="18">
                                                <use xlink:href="#stopIcon" />
                                            </svg>
                                            <span data-i18n-key="stop"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="justSetLine presetSelect" id="azureExtra" style="display:none;">
                                    <div class="presetModelCls">
                                        <label for="preSetVoiceStyle" data-i18n-key="style"></label>
                                        <select id="preSetVoiceStyle">
                                        </select>
                                    </div>
                                    <div class="presetModelCls">
                                        <label for="preSetVoiceRole" data-i18n-key="role"></label>
                                        <select id="preSetVoiceRole">
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <span data-i18n-key="volume"></span>
                                    <input type="range" id="voiceVolume" min="0" max="1" value="1" step="0.1" />
                                    <div class="selectDef">
                                        <span data-i18n-key="low"></span>
                                        <span data-i18n-key="high"></span>
                                    </div>
                                </div>
                                <div>
                                    <span data-i18n-key="rate"></span>
                                    <input type="range" id="voiceRate" min="0.1" max="2" value="1" step="0.1" />
                                    <div class="selectDef">
                                        <span data-i18n-key="slow"></span>
                                        <span data-i18n-key="fast"></span>
                                    </div>
                                </div>
                                <div>
                                    <span data-i18n-key="pitch"></span>
                                    <input type="range" id="voicePitch" min="0" max="2" value="1" step="0.1" />
                                    <div class="selectDef">
                                        <span data-i18n-key="neutral"></span>
                                        <span data-i18n-key="intense"></span>
                                    </div>
                                </div>
                                <div>
                                    <span class="inlineTitle" data-i18n-key="contSpeech"></span>
                                    <label class="switch-slide">
                                        <input type="checkbox" id="enableContVoice" checked="true" hidden />
                                        <label for="enableContVoice" class="switch-slide-label"></label>
                                    </label>
                                </div>
                                <div>
                                    <span class="inlineTitle" data-i18n-key="autoSpeech"></span>
                                    <label class="switch-slide">
                                        <input type="checkbox" id="enableAutoVoice" hidden />
                                        <label for="enableAutoVoice" class="switch-slide-label"></label>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="recOption" style="display: none;">
                            <div id="noRecTip" style="display: block;" data-i18n-key="unsupportRecTip"></div>
                            <div id="yesRec" style="display: none;">
                                <div class="presetSelect presetModelCls">
                                    <label for="selectLangOption" data-i18n-key="lang"></label>
                                    <select id="selectLangOption">
                                    </select>
                                </div>
                                <div class="presetSelect presetModelCls">
                                    <label for="selectDiaOption" data-i18n-key="dialect"></label>
                                    <select id="selectDiaOption">
                                    </select>
                                </div>
                                <div>
                                    <div data-i18n-key="autoSendKey"></div>
                                    <input class="inputTextClass" id="autoSendText" autocomplete="off" data-i18n-place="send" placeholder />
                                </div>
                                <div>
                                    <div data-i18n-key="autoStopKey"></div>
                                    <input class="inputTextClass" id="autoStopText" autocomplete="off" data-i18n-place="stop" placeholder />
                                </div>
                                <div>
                                    <span data-i18n-key="autoSendDelay"></span>
                                    <input type="range" id="autoSendTimeout" min="0" max="10" value="0" step="1" />
                                    <div class="selectDef">
                                        <span>0<span data-i18n-key="second"></span></span>
                                        <span>10<span data-i18n-key="second"></span></span>
                                    </div>
                                </div>
                                <div>
                                    <span class="inlineTitle" data-i18n-key="keepListenMic"></span>
                                    <label class="switch-slide">
                                        <input type="checkbox" id="keepListenMic" checked="false" hidden />
                                        <label for="keepListenMic" class="switch-slide-label"></label>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="messages">
                    <div id="chatlog"></div>
                    <div id="stopChat"><svg width="24" height="24">
                            <use xlink:href="#stopResIcon" />
                        </svg><span data-i18n-key="stop"></span></div>
                </div>
                <div class="bottom_wrapper clearfix">
                    <div class="message_input_wrapper">
                        <textarea class="message_input_text" autocomplete="off" spellcheck="false" data-i18n-place="askTip" placeholder id="chatinput"></textarea>
                        <div id="voiceRec" style="display:none;">
                            <div id="voiceRecIcon">
                                <svg viewBox="0 0 48 48" id="voiceInputIcon">
                                    <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                        <rect fill="none" width="14" height="27" x="17" y="4" rx="7" />
                                        <rect class="animVoice" x="18" y="4" width="12" height="27" stroke="none" fill="currentColor"></rect>
                                        <path stroke-linecap="round" d="M9 23c0 8.284 6.716 15 15 15c8.284 0 15-6.716 15-15M24 38v6" />
                                    </g>
                                </svg>
                            </div>
                            <div id="voiceRecSetting">
                                <select id="select_language" style="margin-bottom: 4px;"></select>
                                <select id="select_dialect"></select>
                            </div>
                        </div>
                    </div>
                    <button class="loaded" id="sendbutton">
                        <span data-i18n-key="send"></span>
                        <svg style="margin:0 auto;height:40px;width:100%;">
                            <use xlink:href="#loadingIcon" />
                        </svg>
                    </button>
                    <button class="clearConv" data-i18n-title="clearChat" title>
                        <svg style="color: #e15b64;" width="29" height="29">
                            <use xlink:href="#closeIcon" />
                        </svg>
                        <svg width="21" height="21">
                            <use xlink:href="#deleteIcon" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="sysMask">
            <div id="sysDialog">
                <div id="closeSet">
                    <svg width="24" height="24">
                        <use xlink:href="#closeIcon" />
                    </svg>
                </div>
                <div class="sysTitle" data-i18n-key="setting"></div>
                <div class="sysContent">
                    <div class="sysSwitch">
                        <div data-id="generalOption" class="activeSwitch">
                            <svg width="24" height="24">
                                <use xlink:href="#settingIcon" />
                            </svg><span data-i18n-key="general"></span>
                        </div>
                        <div data-id="hotkeyOption">
                            <svg width="24" height="24">
                                <use xlink:href="#hotkeyIcon" />
                            </svg><span data-i18n-key="hotkey"></span>
                        </div>
                        <div data-id="dataOption">
                            <svg width="24" height="24">
                                <use xlink:href="#databaseIcon" />
                            </svg><span data-i18n-key="data"></span>
                        </div>
                    </div>
                    <div class="sysDetail">
                        <div id="generalOption">
                            <div class="setContent">
                                <div class="setTitle" data-i18n-key="theme"></div>
                                <div class="setDetail themeDetail lightTheme" id="setLight">
                                    <div data-i18n-title="darkTheme" title>
                                        <svg width="24" height="24">
                                            <use xlink:href="#darkThemeIcon"></use>
                                        </svg>
                                    </div>
                                    <div data-i18n-title="lightTheme" title>
                                        <svg width="24" height="24">
                                            <use xlink:href="#lightThemeIcon"></use>
                                        </svg>
                                    </div>
                                    <div data-i18n-title="autoTheme" title>
                                        <svg width="24" height="24">
                                            <use xlink:href="#autoThemeIcon"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="setContent" id="autoDetail" style="display: none;font-size: 15px;">
                                <div class="setDetail">
                                    <div class="autoSelect">
                                        <input type="radio" id="autoTheme1" name="autoLight" value="1" checked />
                                        <label for="autoTheme1" data-i18n-key="systemTheme"></label>
                                    </div>
                                    <div class="autoSelect" style="margin-top: 8px;">
                                        <input type="radio" id="autoTheme0" name="autoLight" value="0" />
                                        <label for="autoTheme0" data-i18n-key="customDarkTheme"></label>
                                    </div>
                                    <div id="customAutoSet" style="display: none; margin-top: 10px;">
                                        <div>
                                            <label for="customStart" data-i18n-key="startDark"></label>
                                            <input type="time" id="customStart" required>
                                        </div>
                                        <div style="margin-top: 10px;">
                                            <label for="customEnd" data-i18n-key="endDark"></label>
                                            <input type="time" id="customEnd" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setContent">
                                <div class="setTitle" data-i18n-key="lang"></div>
                                <div class="setDetail themeDetail langDetail" id="setLang">
                                    <div title="English">
                                        <svg width="24" height="24">
                                            <use xlink:href="#enIcon"></use>
                                        </svg>
                                    </div>
                                    <div title="中文">
                                        <svg width="24" height="24">
                                            <use xlink:href="#zhIcon"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="setContent setNotNormalFlow">
                                <div class="setTitle" data-i18n-key="aiEndpoint"></div>
                                <div class="setDetail inputDetail" style="position: relative;">
                                    <input class="inputTextClass" value="https://api.yiming.sale" autocomplete="off" id="apiHostInput" />
                                    <div id="apiSelect" tabindex="-1" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="setContent" style="margin-top: 83px;">
                                <div class="setTitle" data-i18n-key="aiKey"></div>
                                <div class="setDetail inputDetail apiDetail">
                                    <input class="inputTextClass" type="text" value="" id="keyInput" autocomplete="off" style="-webkit-text-security: disc;" />
                                </div>
                            </div>
                        </div>
                        <div id="hotkeyOption" style="display: none;">
                            <div class="setContent">
                                <div class="setTitle">UI</div>
                                <div class="setDetail hotKeyDetail">
                                    <div>
                                        <label for="hotKeyNav" data-i18n-key="navKey"></label>
                                        <select id="hotKeyNav">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hotKeyWindow" data-i18n-key="fullKey"></label>
                                        <select id="hotKeyWindow">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hotKeyTheme" data-i18n-key="themeKey"></label>
                                        <select id="hotKeyTheme">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hotKeyLang" data-i18n-key="langKey"></label>
                                        <select id="hotKeyLang">
                                        </select>
                                    </div>
                                </div>
                                <div class="setTitle" data-i18n-key="chat"></div>
                                <div class="setDetail hotKeyDetail">
                                    <div>
                                        <label for="hotKeySearch" data-i18n-key="search"></label>
                                        <select id="hotKeySearch">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hotKeyInput" data-i18n-key="inputKey"></label>
                                        <select id="hotKeyInput">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hotKeyNewChat" data-i18n-key="newChat"></label>
                                        <select id="hotKeyNewChat">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hotKeyClearChat" data-i18n-key="clearChat"></label>
                                        <select id="hotKeyClearChat">
                                        </select>
                                    </div>
                                </div>
                                <div class="setTitle" data-i18n-key="voiceKey"></div>
                                <div class="setDetail hotKeyDetail">
                                    <div style="display: none;">
                                        <label for="hotKeyVoiceRec" data-i18n-key="recKey"></label>
                                        <select id="hotKeyVoiceRec">
                                        </select>
                                    </div>
                                    <div>
                                        <label for="hotKeyVoiceSpeak" data-i18n-key="speechKey"></label>
                                        <select id="hotKeyVoiceSpeak">
                                        </select>
                                    </div>
                                </div>
                                <div class="setDetail keyOptionDetail">
                                    <div id="resetHotKey">
                                        <svg width="22" height="22" style="transform: scaleX(-1)">
                                            <use xlink:href="#refreshIcon" />
                                        </svg>
                                        <span data-i18n-key="resetTip"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="dataOption" style="display: none;">
                            <div class="setContent">
                                <div class="setTitle" data-i18n-key="chat"></div>
                                <div class="setDetail dataDetail">
                                    <div id="exportChat">
                                        <svg width="24" height="24">
                                            <use xlink:href="#exportIcon" />
                                        </svg>
                                        <span data-i18n-key="export"></span>
                                    </div>
                                    <label id="importChat" for="importChatInput">
                                        <svg width="24" height="24">
                                            <use xlink:href="#importIcon" />
                                        </svg>
                                        <span data-i18n-key="import"></span>
                                    </label>
                                    <input type="file" style="display: none;" id="importChatInput" accept="application/json" />
                                    <div id="clearChatSet">
                                        <svg width="24" height="24">
                                            <use xlink:href="#clearAllIcon" />
                                        </svg>
                                        <span data-i18n-key="clear"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="setContent">
                                <div class="setTitle" data-i18n-key="setting"></div>
                                <div class="setDetail dataDetail">
                                    <div id="exportSet">
                                        <svg width="24" height="24">
                                            <use xlink:href="#exportSetIcon" />
                                        </svg>
                                        <span data-i18n-key="export"></span>
                                    </div>
                                    <label id="importSet" for="importSetInput">
                                        <svg width="24" height="24">
                                            <use xlink:href="#importSetIcon" />
                                        </svg>
                                        <span data-i18n-key="import"></span>
                                    </label>
                                    <input type="file" style="display: none;" id="importSetInput" accept="application/json" />
                                    <div id="resetSet">
                                        <svg width="22" height="22" style="transform: scaleX(-1)">
                                            <use xlink:href="#refreshIcon" />
                                        </svg>
                                        <span data-i18n-key="reset"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="setContent">
                                <div class="setTitle" data-i18n-key="localStore"></div>
                                <div class="setDetail">
                                    <div class="progressBar">
                                        <div class="nowProgress" id="usedStorageBar"></div>
                                    </div>
                                    <div class="progressDetail">
                                        <div><span data-i18n-key="used"></span><span id="usedStorage"></span></div>
                                        <div><span data-i18n-key="available"></span><span id="availableStorage"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link crossorigin="anonymous" href="//cdn.staticfile.org/github-markdown-css/5.3.0/github-markdown-light.min.css" rel="stylesheet">
        <link crossorigin="anonymous" href="//cdn.staticfile.org/highlight.js/11.9.0/styles/github.min.css" rel="stylesheet">
        <link crossorigin="anonymous" href="//cdn.staticfile.org/notyf/3.10.0/notyf.min.css" rel="stylesheet">

        <script crossorigin="anonymous" src="//cdn.staticfile.org/notyf/3.10.0/notyf.min.js"></script>
        <script>
            const notyf = new Notyf({
                position: {
                    x: "center",
                    y: "top"
                },
                types: [{
                        type: "success",
                        background: "#99c959",
                        duration: 2000,
                    },
                    {
                        type: "warning",
                        background: "#f8b26a",
                        duration: 3000
                    },
                    {
                        type: "error",
                        background: "#e15b64",
                        duration: 3000,
                    }
                ]
            });
            const registerSW = () => {
                if ("serviceWorker" in navigator) {
                    navigator.serviceWorker.register("sw.js" + location.search).then(reg => console.log("Service worker register succeeded"),
                        error => console.error(`Service worker register failed: ${error}`))
                }
            };
            window.addEventListener("load", () => registerSW());
            const isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|BlackBerry|webOS/);
            if (isMobile) {
                const script = document.createElement("script");
                script.src = "https://cdn.jsdelivr.net/gh/timruffles/mobile-drag-drop@3.0.0-rc.0/release/index.min.js";
                script.crossOrigin = "anonymous";
                script.defer = true;
                script.onload = () => {
                    MobileDragDrop.polyfill();
                }
                document.body.appendChild(script);
                const link = document.createElement("link");
                link.crossOrigin = "anonymous";
                link.rel = "stylesheet";
                link.href = "https://cdn.jsdelivr.net/gh/timruffles/mobile-drag-drop@3.0.0-rc.0/release/default.css";
                document.body.appendChild(link);
            }
            let envAPIEndpoint, envAPIKey;
        </script>
        <script src="env.js"></script>
        <script>
            {
                const t = Uint8Array,
                    e = Uint16Array,
                    n = Int32Array,
                    r = new t([0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 0, 0, 0, 0]),
                    o = new t([0, 0, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13, 0, 0]),
                    l = new t([16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15]),
                    s = (t, r) => {
                        const o = new e(31);
                        for (let e = 0; e < 31; ++e) o[e] = r += 1 << t[e - 1];
                        const l = new n(o[30]);
                        for (let t = 1; t < 30; ++t)
                            for (let e = o[t]; e < o[t + 1]; ++e) l[e] = e - o[t] << 5 | t;
                        return {
                            b: o,
                            r: l
                        }
                    },
                    {
                        b: f,
                        r: c
                    } = s(r, 2);
                f[28] = 258, c[258] = 28;
                const {
                    b: i,
                    r: a
                } = s(o, 0), h = new e(32768);
                for (let t = 0; t < 32768; ++t) {
                    let e = (43690 & t) >> 1 | (21845 & t) << 1;
                    e = (52428 & e) >> 2 | (13107 & e) << 2, e = (61680 & e) >> 4 | (3855 & e) << 4, h[t] = ((65280 & e) >> 8 | (255 & e) << 8) >> 1
                }
                const u = (t, n, r) => {
                        const o = t.length;
                        let l = 0;
                        const s = new e(n);
                        for (; l < o; ++l) t[l] && ++s[t[l] - 1];
                        const f = new e(n);
                        for (l = 1; l < n; ++l) f[l] = f[l - 1] + s[l - 1] << 1;
                        let c;
                        if (r) {
                            c = new e(1 << n);
                            const r = 15 - n;
                            for (l = 0; l < o; ++l)
                                if (t[l]) {
                                    const e = l << 4 | t[l],
                                        o = n - t[l];
                                    let s = f[t[l] - 1]++ << o;
                                    for (const t = s | (1 << o) - 1; s <= t; ++s) c[h[s] >> r] = e
                                }
                        } else
                            for (c = new e(o), l = 0; l < o; ++l) t[l] && (c[l] = h[f[t[l] - 1]++] >> 15 - t[l]);
                        return c
                    },
                    w = new t(288);
                for (let t = 0; t < 144; ++t) w[t] = 8;
                for (let t = 144; t < 256; ++t) w[t] = 9;
                for (let t = 256; t < 280; ++t) w[t] = 7;
                for (let t = 280; t < 288; ++t) w[t] = 8;
                const g = new t(32);
                for (let t = 0; t < 32; ++t) g[t] = 5;
                const b = u(w, 9, 0),
                    d = u(w, 9, 1),
                    m = u(g, 5, 0),
                    y = u(g, 5, 1),
                    M = t => {
                        let e = t[0];
                        for (let n = 1; n < t.length; ++n) t[n] > e && (e = t[n]);
                        return e
                    },
                    p = (t, e, n) => {
                        const r = e / 8 | 0;
                        return (t[r] | t[r + 1] << 8) >> (7 & e) & n
                    },
                    k = (t, e) => {
                        const n = e / 8 | 0;
                        return (t[n] | t[n + 1] << 8 | t[n + 2] << 16) >> (7 & e)
                    },
                    v = t => (t + 7) / 8 | 0,
                    x = (e, n, r) => {
                        (null == n || n < 0) && (n = 0), (null == r || r > e.length) && (r = e.length);
                        const o = new t(r - n);
                        return o.set(e.subarray(n, r)), o
                    },
                    E = ["unexpected EOF", "invalid block type", "invalid length/literal", "invalid distance", "stream finished", "no stream handler", , "no callback", "invalid UTF-8 data", "extra field too long", "date not in range 1980-2099", "filename too long", "stream finishing", "invalid zip data"],
                    A = (t, e, n) => {
                        const r = new Error(e || E[t]);
                        if (r.code = t, Error.captureStackTrace && Error.captureStackTrace(r, A), !n) throw r;
                        return r
                    },
                    T = (e, n, s, c) => {
                        const a = e.length,
                            h = c ? c.length : 0;
                        if (!a || n.f && !n.l) return s || new t(0);
                        const w = !s || 2 != n.i,
                            g = n.i;
                        s || (s = new t(3 * a));
                        const b = e => {
                            let n = s.length;
                            if (e > n) {
                                const r = new t(Math.max(2 * n, e));
                                r.set(s), s = r
                            }
                        };
                        let m = n.f || 0,
                            E = n.p || 0,
                            T = n.b || 0,
                            U = n.l,
                            z = n.d,
                            F = n.m,
                            S = n.n;
                        const I = 8 * a;
                        do {
                            if (!U) {
                                m = p(e, E, 1);
                                const r = p(e, E + 1, 3);
                                if (E += 3, !r) {
                                    const t = v(E) + 4,
                                        r = e[t - 4] | e[t - 3] << 8,
                                        o = t + r;
                                    if (o > a) {
                                        g && A(0);
                                        break
                                    }
                                    w && b(T + r), s.set(e.subarray(t, o), T), n.b = T += r, n.p = E = 8 * o, n.f = m;
                                    continue
                                }
                                if (1 == r) U = d, z = y, F = 9, S = 5;
                                else if (2 == r) {
                                    const n = p(e, E, 31) + 257,
                                        r = p(e, E + 10, 15) + 4,
                                        o = n + p(e, E + 5, 31) + 1;
                                    E += 14;
                                    const s = new t(o),
                                        f = new t(19);
                                    for (let t = 0; t < r; ++t) f[l[t]] = p(e, E + 3 * t, 7);
                                    E += 3 * r;
                                    const c = M(f),
                                        i = (1 << c) - 1,
                                        a = u(f, c, 1);
                                    for (let t = 0; t < o;) {
                                        const n = a[p(e, E, i)];
                                        E += 15 & n;
                                        const r = n >> 4;
                                        if (r < 16) s[t++] = r;
                                        else {
                                            let n = 0,
                                                o = 0;
                                            for (16 == r ? (o = 3 + p(e, E, 3), E += 2, n = s[t - 1]) : 17 == r ? (o = 3 + p(e, E, 7), E += 3) : 18 == r && (o = 11 + p(e, E, 127), E += 7); o--;) s[t++] = n
                                        }
                                    }
                                    const h = s.subarray(0, n),
                                        w = s.subarray(n);
                                    F = M(h), S = M(w), U = u(h, F, 1), z = u(w, S, 1)
                                } else A(1);
                                if (E > I) {
                                    g && A(0);
                                    break
                                }
                            }
                            w && b(T + 131072);
                            const x = (1 << F) - 1,
                                O = (1 << S) - 1;
                            let j = E;
                            for (;; j = E) {
                                const t = U[k(e, E) & x],
                                    n = t >> 4;
                                if (E += 15 & t, E > I) {
                                    g && A(0);
                                    break
                                }
                                if (t || A(2), n < 256) s[T++] = n;
                                else {
                                    if (256 == n) {
                                        j = E, U = null;
                                        break
                                    } {
                                        let t = n - 254;
                                        if (n > 264) {
                                            const o = n - 257,
                                                l = r[o];
                                            t = p(e, E, (1 << l) - 1) + f[o], E += l
                                        }
                                        const l = z[k(e, E) & O],
                                            a = l >> 4;
                                        l || A(3), E += 15 & l;
                                        let u = i[a];
                                        if (a > 3) {
                                            const t = o[a];
                                            u += k(e, E) & (1 << t) - 1, E += t
                                        }
                                        if (E > I) {
                                            g && A(0);
                                            break
                                        }
                                        w && b(T + 131072);
                                        const d = T + t;
                                        if (T < u) {
                                            const t = h - u,
                                                e = Math.min(u, d);
                                            for (t + T < 0 && A(3); T < e; ++T) s[T] = c[t + T]
                                        }
                                        for (; T < d; T += 4) s[T] = s[T - u], s[T + 1] = s[T + 1 - u], s[T + 2] = s[T + 2 - u], s[T + 3] = s[T + 3 - u];
                                        T = d
                                    }
                                }
                            }
                            n.l = U, n.p = j, n.b = T, n.f = m, U && (m = 1, n.m = F, n.d = z, n.n = S)
                        } while (!m);
                        return T == s.length ? s : x(s, 0, T)
                    },
                    U = (t, e, n) => {
                        n <<= 7 & e;
                        const r = e / 8 | 0;
                        t[r] |= n, t[r + 1] |= n >> 8
                    },
                    z = (t, e, n) => {
                        n <<= 7 & e;
                        const r = e / 8 | 0;
                        t[r] |= n, t[r + 1] |= n >> 8, t[r + 2] |= n >> 16
                    },
                    F = (n, r) => {
                        const o = [];
                        for (let t = 0; t < n.length; ++t) n[t] && o.push({
                            s: t,
                            f: n[t]
                        });
                        const l = o.length,
                            s = o.slice();
                        if (!l) return {
                            t: C,
                            l: 0
                        };
                        if (1 == l) {
                            const e = new t(o[0].s + 1);
                            return e[o[0].s] = 1, {
                                t: e,
                                l: 1
                            }
                        }
                        o.sort(((t, e) => t.f - e.f)), o.push({
                            s: -1,
                            f: 25001
                        });
                        let f = o[0],
                            c = o[1],
                            i = 0,
                            a = 1,
                            h = 2;
                        for (o[0] = {
                                s: -1,
                                f: f.f + c.f,
                                l: f,
                                r: c
                            }; a != l - 1;) f = o[o[i].f < o[h].f ? i++ : h++], c = o[i != a && o[i].f < o[h].f ? i++ : h++], o[a++] = {
                            s: -1,
                            f: f.f + c.f,
                            l: f,
                            r: c
                        };
                        let u = s[0].s;
                        for (let t = 1; t < l; ++t) s[t].s > u && (u = s[t].s);
                        const w = new e(u + 1);
                        let g = S(o[a - 1], w, 0);
                        if (g > r) {
                            let t = 0,
                                e = 0;
                            const n = g - r,
                                o = 1 << n;
                            for (s.sort(((t, e) => w[e.s] - w[t.s] || t.f - e.f)); t < l; ++t) {
                                const n = s[t].s;
                                if (!(w[n] > r)) break;
                                e += o - (1 << g - w[n]), w[n] = r
                            }
                            for (e >>= n; e > 0;) {
                                const n = s[t].s;
                                w[n] < r ? e -= 1 << r - w[n]++ - 1 : ++t
                            }
                            for (; t >= 0 && e; --t) {
                                const n = s[t].s;
                                w[n] == r && (--w[n], ++e)
                            }
                            g = r
                        }
                        return {
                            t: new t(w),
                            l: g
                        }
                    },
                    S = (t, e, n) => -1 == t.s ? Math.max(S(t.l, e, n + 1), S(t.r, e, n + 1)) : e[t.s] = n,
                    I = t => {
                        let n = t.length;
                        for (; n && !t[--n];);
                        const r = new e(++n);
                        let o = 0,
                            l = t[0],
                            s = 1;
                        const f = t => {
                            r[o++] = t
                        };
                        for (let e = 1; e <= n; ++e)
                            if (t[e] == l && e != n) ++s;
                            else {
                                if (!l && s > 2) {
                                    for (; s > 138; s -= 138) f(32754);
                                    s > 2 && (f(s > 10 ? s - 11 << 5 | 28690 : s - 3 << 5 | 12305), s = 0)
                                } else if (s > 3) {
                                    for (f(l), --s; s > 6; s -= 6) f(8304);
                                    s > 2 && (f(s - 3 << 5 | 8208), s = 0)
                                }
                                for (; s--;) f(l);
                                s = 1, l = t[e]
                            } return {
                            c: r.subarray(0, o),
                            n: n
                        }
                    },
                    O = (t, e) => {
                        let n = 0;
                        for (let r = 0; r < e.length; ++r) n += t[r] * e[r];
                        return n
                    },
                    j = (t, e, n) => {
                        const r = n.length,
                            o = v(e + 2);
                        t[o] = 255 & r, t[o + 1] = r >> 8, t[o + 2] = 255 ^ t[o], t[o + 3] = 255 ^ t[o + 1];
                        for (let e = 0; e < r; ++e) t[o + e + 4] = n[e];
                        return 8 * (o + 4 + r)
                    },
                    q = (t, n, s, f, c, i, a, h, d, y, M) => {
                        U(n, M++, s), ++c[256];
                        const {
                            t: p,
                            l: k
                        } = F(c, 15), {
                            t: v,
                            l: x
                        } = F(i, 15), {
                            c: E,
                            n: A
                        } = I(p), {
                            c: T,
                            n: S
                        } = I(v), q = new e(19);
                        for (let t = 0; t < E.length; ++t) ++q[31 & E[t]];
                        for (let t = 0; t < T.length; ++t) ++q[31 & T[t]];
                        const {
                            t: B,
                            l: C
                        } = F(q, 7);
                        let D = 19;
                        for (; D > 4 && !B[l[D - 1]]; --D);
                        const G = y + 5 << 3,
                            H = O(c, w) + O(i, g) + a,
                            J = O(c, p) + O(i, v) + a + 14 + 3 * D + O(q, B) + 2 * q[16] + 3 * q[17] + 7 * q[18];
                        if (d >= 0 && G <= H && G <= J) return j(n, M, t.subarray(d, d + y));
                        let K, L, N, P;
                        if (U(n, M, 1 + (J < H)), M += 2, J < H) {
                            K = u(p, k, 0), L = p, N = u(v, x, 0), P = v;
                            const t = u(B, C, 0);
                            U(n, M, A - 257), U(n, M + 5, S - 1), U(n, M + 10, D - 4), M += 14;
                            for (let t = 0; t < D; ++t) U(n, M + 3 * t, B[l[t]]);
                            M += 3 * D;
                            const e = [E, T];
                            for (let r = 0; r < 2; ++r) {
                                const o = e[r];
                                for (let e = 0; e < o.length; ++e) {
                                    const r = 31 & o[e];
                                    U(n, M, t[r]), M += B[r], r > 15 && (U(n, M, o[e] >> 5 & 127), M += o[e] >> 12)
                                }
                            }
                        } else K = b, L = w, N = m, P = g;
                        for (let t = 0; t < h; ++t) {
                            const e = f[t];
                            if (e > 255) {
                                const t = e >> 18 & 31;
                                z(n, M, K[t + 257]), M += L[t + 257], t > 7 && (U(n, M, e >> 23 & 31), M += r[t]);
                                const l = 31 & e;
                                z(n, M, N[l]), M += P[l], l > 3 && (z(n, M, e >> 5 & 8191), M += o[l])
                            } else z(n, M, K[e]), M += L[e]
                        }
                        return z(n, M, K[256]), M + L[256]
                    },
                    B = new n([65540, 131080, 131088, 131104, 262176, 1048704, 1048832, 2114560, 2117632]),
                    C = new t(0),
                    D = (l, s, f, i, h, u) => {
                        const w = u.z || l.length,
                            g = new t(i + w + 5 * (1 + Math.ceil(w / 7e3)) + h),
                            b = g.subarray(i, g.length - h),
                            d = u.l;
                        let m = 7 & (u.r || 0);
                        if (s) {
                            m && (b[0] = u.r >> 3);
                            const t = B[s - 1],
                                i = t >> 13,
                                h = 8191 & t,
                                g = (1 << f) - 1,
                                y = u.p || new e(32768),
                                M = u.h || new e(g + 1),
                                p = Math.ceil(f / 3),
                                k = 2 * p,
                                v = t => (l[t] ^ l[t + 1] << p ^ l[t + 2] << k) & g,
                                x = new n(25e3),
                                E = new e(288),
                                A = new e(32);
                            let T = 0,
                                U = 0,
                                z = u.i || 0,
                                F = 0,
                                S = u.w || 0,
                                I = 0;
                            for (; z + 2 < w; ++z) {
                                const t = v(z);
                                let e = 32767 & z,
                                    n = M[t];
                                if (y[e] = n, M[t] = e, S <= z) {
                                    const s = w - z;
                                    if ((T > 7e3 || F > 24576) && (s > 423 || !d)) {
                                        m = q(l, b, 0, x, E, A, U, F, I, z - I, m), F = T = U = 0, I = z;
                                        for (let t = 0; t < 286; ++t) E[t] = 0;
                                        for (let t = 0; t < 30; ++t) A[t] = 0
                                    }
                                    let f = 2,
                                        u = 0,
                                        g = h,
                                        M = e - n & 32767;
                                    if (s > 2 && t == v(z - M)) {
                                        const t = Math.min(i, s) - 1,
                                            r = Math.min(32767, z),
                                            o = Math.min(258, s);
                                        for (; M <= r && --g && e != n;) {
                                            if (l[z + f] == l[z + f - M]) {
                                                let e = 0;
                                                for (; e < o && l[z + e] == l[z + e - M]; ++e);
                                                if (e > f) {
                                                    if (f = e, u = M, e > t) break;
                                                    const r = Math.min(M, e - 2);
                                                    let o = 0;
                                                    for (let t = 0; t < r; ++t) {
                                                        const e = z - M + t & 32767,
                                                            r = e - y[e] & 32767;
                                                        r > o && (o = r, n = e)
                                                    }
                                                }
                                            }
                                            e = n, n = y[e], M += e - n & 32767
                                        }
                                    }
                                    if (u) {
                                        x[F++] = 268435456 | c[f] << 18 | a[u];
                                        const t = 31 & c[f],
                                            e = 31 & a[u];
                                        U += r[t] + o[e], ++E[257 + t], ++A[e], S = z + f, ++T
                                    } else x[F++] = l[z], ++E[l[z]]
                                }
                            }
                            for (z = Math.max(z, S); z < w; ++z) x[F++] = l[z], ++E[l[z]];
                            m = q(l, b, d, x, E, A, U, F, I, z - I, m), d || (u.r = 7 & m | b[m / 8 | 0] << 3, m -= 7, u.h = M, u.p = y, u.i = z, u.w = S)
                        } else {
                            for (let t = u.w || 0; t < w + d; t += 65535) {
                                let e = t + 65535;
                                e >= w && (b[m / 8 | 0] = d, e = w), m = j(b, m + 1, l.subarray(t, e))
                            }
                            u.i = w
                        }
                        return x(g, 0, i + v(m) + h)
                    },
                    G = (e, n, r, o, l) => {
                        if (!l && (l = {
                                l: 1
                            }, n.dictionary)) {
                            const r = n.dictionary.subarray(-32768),
                                o = new t(r.length + e.length);
                            o.set(r), o.set(e, r.length), e = o, l.w = r.length
                        }
                        return D(e, null == n.level ? 6 : n.level, null == n.mem ? Math.ceil(1.5 * Math.max(8, Math.min(13, Math.log(e.length)))) : 12 + n.mem, r, o, l)
                    };

                function H(t, e) {
                    return G(t, e || {}, 0, 0)
                }

                function J(t, e) {
                    return T(t, {
                        i: 2
                    }, e && e.out, e && e.dictionary)
                }
                self.deflateSync = H;
                self.inflateSync = J;
            }
        </script>
        <script>
            const stringToUint = string => {
                let uintArray = new Uint8Array(string.length);
                for (let i = 0; i < string.length; i++) {
                    uintArray[i] = string.charCodeAt(i);
                }
                return uintArray;
            }
            const uintToString = uintArray => {
                let str = "";
                let len = Math.ceil(uintArray.byteLength / 32767);
                for (let i = 0; i < len; i++) {
                    str += String.fromCharCode.apply(null, uintArray.subarray(i * 32767, Math.min((i + 1) * 32767, uintArray.byteLength)));
                }
                return str;
            }
            let isCompressedChats = localStorage.getItem("compressedChats") === "true";
            const originSetItem = localStorage.setItem;
            localStorage.setItem = (key, value) => {
                try {
                    if (isCompressedChats && key === "chats") value = uintToString(deflateSync(new TextEncoder().encode(value), {
                        level: 1
                    }));
                    originSetItem.call(localStorage, key, value)
                } catch (e) {
                    if (isCompressedChats) {
                        notyf.error(translations[locale]["localQuotaExceedTip"])
                        return;
                    }
                    let isKeyChats = key === "chats";
                    let compressed = uintToString(deflateSync(new TextEncoder().encode(isKeyChats ? value : localStorage.getItem("chats")), {
                        level: 1
                    }));
                    originSetItem.call(localStorage, "chats", compressed);
                    originSetItem.call(localStorage, "compressedChats", true);
                    isCompressedChats = true;
                    if (!isKeyChats) originSetItem.call(localStorage, key, value);
                }
            }
        </script>
        <script>
            const localeList = ["en", "zh"];
            let locale; // UI语言
            const setLangEle = document.getElementById("setLang");
            const setLang = () => {
                let langClass = locale + "Lang";
                localStorage.setItem("UILang", locale)
                setLangEle.classList = "setDetail themeDetail langDetail " + langClass;
            }
            setLangEle.onclick = (ev) => {
                let idx = Array.prototype.indexOf.call(setLangEle.children, ev.target);
                if (locale !== localeList[idx]) {
                    locale = localeList[idx];
                    setLang();
                    changeLocale();
                }
            }
            const initLang = () => {
                let localLang = localStorage.getItem("UILang") || (navigator.language.startsWith("zh-") ? "zh" : "en");
                let isInit = locale === void 0;
                if (locale !== localLang) {
                    locale = localLang;
                    if (!isInit) changeLocale();
                };
                setLang();
            }
            initLang();
            const translations = {
                "en": {
                    "description": "Simple and powerful ChatGPT app",
                    "newChat": "New chat",
                    "newChatName": "New chat",
                    "newFolder": "New folder",
                    "newFolderName": "New folder",
                    "search": "Search",
                    "matchCaseTip": "Match case",
                    "forceRe": "Force refresh",
                    "clearAll": "Clear all chats",
                    "setting": "Setting",
                    "nav": "Navigate",
                    "winedWin": "Window",
                    "fullWin": "Full screen",
                    "quickSet": "Quick setting",
                    "chat": "Chat",
                    "tts": "TTS",
                    "stt": "STT",
                    "gptModel": "GPT model",
                    "gptBrowsing": "GPT-4-browsing",
                    "avatar": "Avatar",
                    "systemRole": "System role",
                    "presetRole": "Preset",
                    "default": "Default",
                    "assistant": "Assistant",
                    "cat": "Cat girl",
                    "emoji": "Emoji",
                    "withImg": "Image",
                    "defaultText": "",
                    "assistantText": "You are a helpful assistant, answer as concisely as possible.",
                    "catText": "You are a cute cat girl, you must end every sentence with 'meow'",
                    "emojiText": "Your personality is very lively, there must be at least one emoji icon in every sentence",
                    "imageText": "When you need to send pictures, please generate them in markdown language, without backslashes or code boxes. When you need to use the unsplash API, follow the format, https://source.unsplash.com/960x640/?<English keywords>",
                    "nature": "Nature",
                    "natureNeg": "Accurate",
                    "naturePos": "Creativity",
                    "quality": "Quality",
                    "qualityNeg": "Repetitive",
                    "qualityPos": "Nonsense",
                    "chatsWidth": "Chats width",
                    "typeSpeed": "Typing speed",
                    "continuousLen": "Context messages",
                    "msgAbbr": " msgs.",
                    "slow": "Slow",
                    "fast": "Fast",
                    "longReply": "Long reply",
                    "ttsService": "TTS API",
                    "azureTTS": "Azure",
                    "edgeTTS": "Edge",
                    "systemTTS": "System",
                    "azureRegion": "Azure region",
                    "loadVoice": "Load voice",
                    "voiceName": "Choose voice",
                    "userVoice": "User voice",
                    "replyVoice": "Reply voice",
                    "TTSTest": "Hello, nice to meet you.",
                    "play": "Play",
                    "pause": "Pause",
                    "resume": "Resume",
                    "stop": "Stop",
                    "style": "Style",
                    "role": "Role",
                    "volume": "Volume",
                    "low": "Low",
                    "high": "High",
                    "rate": "Rate",
                    "slow": "Slow",
                    "fast": "Fast",
                    "pitch": "Pitch",
                    "neutral": "Neutral",
                    "intense": "Intense",
                    "contSpeech": "Continuous speech",
                    "autoSpeech": "Auto speech",
                    "unsupportRecTip": "Voice recognition is not supported in the current environment. Please refer to the documentation.",
                    "lang": "Language",
                    "dialect": "Dialect",
                    "autoSendKey": "Auto send keyword",
                    "autoStopKey": "Auto stop keyword",
                    "autoSendDelay": "Auto send delay time",
                    "second": "s",
                    "keepListenMic": "Keep listen",
                    "send": "Send",
                    "askTip": "Type message here",
                    "clearChat": "Clear chat",
                    "general": "General",
                    "hotkey": "Hotkey",
                    "data": "Data",
                    "theme": "Theme",
                    "darkTheme": "Dark",
                    "lightTheme": "Light",
                    "autoTheme": "Auto",
                    "systemTheme": "System",
                    "customDarkTheme": "Custom dark theme",
                    "startDark": "Start",
                    "endDark": "End",
                    "aiEndpoint": "OpenAI endpoint",
                    "aiKey": "OpenAI API key",
                    "used": "Used ",
                    "available": "Avail ",
                    "navKey": "Toggle nav",
                    "fullKey": "Window size",
                    "themeKey": "Toggle theme",
                    "themeKey": "Toggle lang",
                    "inputKey": "Message",
                    "voiceKey": "Voice",
                    "resetTip": "Restore default",
                    "recKey": "Recognition",
                    "speechKey": "Start speech",
                    "export": "Export",
                    "import": "Import",
                    "clear": "Clear",
                    "reset": "Reset",
                    "localStore": "Local storage",
                    "forceReTip": "Force refresh page?",
                    "noSpeechTip": "No speech was detected. You may need to adjust your microphone settings.",
                    "noMicTip": "No microphone was found. Ensure that a microphone is installed and microphone settings are configured correctly.",
                    "noMicPerTip": "Permission to use microphone is blocked.",
                    "azureInvalidTip": "Access is denied due to invalid access key or API endpoint!",
                    "errorAiKeyTip": "Invalid or incorrect API key, please check API key!",
                    "copyCode": "Copy code",
                    "copySuccess": "Success",
                    "update": "Update",
                    "cancel": "Cancel",
                    "delMsgTip": "Delete this message?",
                    "edit": "Edit",
                    "refresh": "Refresh",
                    "continue": "Continue",
                    "copy": "Copy",
                    "del": "Delete",
                    "downAudio": "Download audio",
                    "speech": "Speech",
                    "chats": " chats",
                    "delFolderTip": "Delete this folder?",
                    "delChatTip": "Delete this chat?",
                    "exportSuccTip": "Export successful!",
                    "importSuccTip": "Import successful!",
                    "importFailTip": "Import failed, please check the file format!",
                    "clearChatSuccTip": "Clear chats data successful!",
                    "resetSetSuccTip": "Reset settings successful!",
                    "clearAllTip": "Delete all chats and folders?",
                    "resetSetTip": "Restore all settings to default?",
                    "hotkeyConflict": "Hotkey conflict, please choose another key!",
                    "customDarkTip": "Start time and end time cannot be the same!",
                    "timeoutTip": "Request timeout, please try again later!",
                    "largeReqTip": "Request is too large, please delete part of the chat or cancel continuous chat!",
                    "noModelPerTip": "Not permission to use this model, please choose another GPT model!",
                    "apiRateTip": "Trigger API call rate limit, please try again later!",
                    "exceedLimitTip": "API usage exceeded limit, please check your bill!",
                    "badGateTip": "Gateway error or timeout, please try again later!",
                    "badEndpointTip": "Failed to access the endpoint, please check the endpoint!",
                    "clearChatTip": "Clear this chat?",
                    "cantSpeechTip": "Current voice cannot synthesize this message, please choose another voice or message!",
                    "localQuotaExceedTip": "Local storage exceeded limit, please export chats data and clear or delete some chats!",
                },
                "zh": {
                    "description": "简洁而强大的ChatGPT应用",
                    "newChat": "新建会话",
                    "newChatName": "新的会话",
                    "newFolder": "新建文件夹",
                    "newFolderName": "新文件夹",
                    "search": "搜索",
                    "matchCaseTip": "区分大小写",
                    "forceRe": "强制刷新",
                    "clearAll": "清空全部",
                    "setting": "设置",
                    "nav": "导航",
                    "winedWin": "窗口",
                    "fullWin": "全屏",
                    "quickSet": "快速设置",
                    "chat": "会话",
                    "tts": "语音合成",
                    "stt": "语音识别",
                    "gptModel": "GPT模型",
                    "gptBrowsing": "GPT-4-联网",
                    "avatar": "用户头像",
                    "systemRole": "系统角色",
                    "presetRole": "预设角色",
                    "default": "默认",
                    "assistant": "助手",
                    "cat": "猫娘",
                    "emoji": "表情",
                    "withImg": "有图",
                    "defaultText": "",
                    "assistantText": "你是一个乐于助人的助手，尽量简明扼要地回答",
                    "catText": "你是一个可爱的猫娘，每句话结尾都要带个'喵'",
                    "emojiText": "你的性格很活泼，每句话中都要有至少一个emoji图标",
                    "imageText": "当你需要发送图片的时候，请用 markdown 语言生成，不要反斜线，不要代码框，需要使用 unsplash API时，遵循一下格式， https://source.unsplash.com/960x640/? ＜英文关键词＞",
                    "nature": "角色性格",
                    "natureNeg": "准确严谨",
                    "naturePos": "灵活创新",
                    "quality": "回答质量",
                    "qualityNeg": "重复保守",
                    "qualityPos": "胡言乱语",
                    "chatsWidth": "会话宽度",
                    "typeSpeed": "打字机速度",
                    "continuousLen": "上下文消息数",
                    "msgAbbr": "条",
                    "slow": "慢",
                    "fast": "快",
                    "longReply": "长回复",
                    "ttsService": "语音合成服务",
                    "azureTTS": "Azure语音",
                    "edgeTTS": "Edge语音",
                    "systemTTS": "系统语音",
                    "azureRegion": "Azure区域",
                    "loadVoice": "加载语音",
                    "voiceName": "选择语音",
                    "userVoice": "用户语音",
                    "replyVoice": "回答语音",
                    "TTSTest": "你好，很高兴认识你。",
                    "play": "播放",
                    "pause": "暂停",
                    "resume": "恢复",
                    "stop": "停止",
                    "style": "风格",
                    "role": "角色",
                    "volume": "音量",
                    "low": "低",
                    "high": "高",
                    "rate": "语速",
                    "slow": "慢",
                    "fast": "快",
                    "pitch": "音调",
                    "neutral": "平淡",
                    "intense": "起伏",
                    "contSpeech": "连续朗读",
                    "autoSpeech": "自动朗读",
                    "unsupportRecTip": "当前环境不支持语音识别，请查阅文档。",
                    "lang": "语言",
                    "dialect": "方言",
                    "autoSendKey": "自动发送关键词",
                    "autoStopKey": "自动停止关键词",
                    "autoSendDelay": "自动发送延迟时间",
                    "second": "秒",
                    "keepListenMic": "保持监听",
                    "send": "发送",
                    "askTip": "来问点什么吧",
                    "clearChat": "清空会话",
                    "general": "通用",
                    "hotkey": "快捷键",
                    "data": "数据",
                    "theme": "主题",
                    "darkTheme": "深色",
                    "lightTheme": "浅色",
                    "autoTheme": "自动",
                    "systemTheme": "跟随系统",
                    "customDarkTheme": "自定义深色主题时间",
                    "startDark": "开始时间",
                    "endDark": "结束时间",
                    "aiEndpoint": "OpenAI接口",
                    "aiKey": "API密钥",
                    "used": "已用 ",
                    "available": "可用 ",
                    "navKey": "切换导航",
                    "fullKey": "全屏/窗口",
                    "themeKey": "切换主题",
                    "langKey": "切换语言",
                    "inputKey": "输入框",
                    "voiceKey": "语音",
                    "resetTip": "重置设置",
                    "recKey": "语音输入",
                    "speechKey": "朗读会话",
                    "export": "导出",
                    "import": "导入",
                    "clear": "清空",
                    "reset": "重置",
                    "localStore": "本地存储",
                    "forceReTip": "是否强制刷新页面？",
                    "noSpeechTip": "未识别到语音，请调整麦克风后重试！",
                    "noMicTip": "未识别到麦克风，请确保已安装麦克风！",
                    "noMicPerTip": "未允许麦克风权限！",
                    "azureInvalidTip": "由于订阅密钥无效或 API 端点错误，访问被拒绝！",
                    "errorAiKeyTip": "API密钥错误或失效，请检查API密钥！",
                    "copyCode": "复制代码",
                    "copySuccess": "复制成功",
                    "update": "更新",
                    "cancel": "取消",
                    "delMsgTip": "是否删除此消息？",
                    "edit": "编辑",
                    "refresh": "刷新",
                    "continue": "继续",
                    "copy": "复制",
                    "del": "删除",
                    "downAudio": "下载语音",
                    "speech": "朗读",
                    "chats": "个会话",
                    "delFolderTip": "是否删除此文件夹？",
                    "delChatTip": "是否删除此会话？",
                    "exportSuccTip": "导出成功！",
                    "importSuccTip": "导入成功！",
                    "importFailTip": "导入失败，请检查文件格式！",
                    "clearChatSuccTip": "清空会话成功！",
                    "resetSetSuccTip": "重置设置成功！",
                    "clearAllTip": "是否删除所有会话和文件夹？",
                    "resetSetTip": "是否还原所有设置为默认值？",
                    "hotkeyConflict": "快捷键冲突，请选择其他键位！",
                    "customDarkTip": "开始时间和结束时间不能相同！",
                    "timeoutTip": "请求超时，请稍后重试！",
                    "largeReqTip": "请求内容过大，请删除部分对话或关闭连续对话！",
                    "noModelPerTip": "无权使用此模型，请选择其他GPT模型！",
                    "apiRateTip": "触发API调用频率限制，请稍后重试！",
                    "exceedLimitTip": "API使用超出限额，请检查您的账单！",
                    "badGateTip": "网关错误或超时，请稍后重试！",
                    "badEndpointTip": "访问接口失败，请检查接口！",
                    "clearChatTip": "是否清空此会话？",
                    "cantSpeechTip": "当前语音无法合成此消息，请选择其他语音或消息！",
                    "localQuotaExceedTip": "本地存储超出限额，请导出会话并清空或删除部分会话！",
                },
            };
            const translateElement = (ele, type) => {
                const key = ele.getAttribute("data-i18n-" + type);
                const translation = translations[locale][key];
                if (type === "title") {
                    ele.setAttribute("title", translation);
                } else if (type === "place") {
                    ele.setAttribute("placeholder", translation);
                } else if (type === "value") {
                    ele.setAttribute("value", translation);
                } else {
                    ele.textContent = translation;
                }
            }
            const initLocale = () => {
                document.querySelectorAll("[data-i18n-title]").forEach(ele => {
                    translateElement(ele, "title")
                });
                document.querySelectorAll("[data-i18n-place]").forEach(ele => {
                    translateElement(ele, "place")
                });
                document.querySelectorAll("[data-i18n-value]").forEach(ele => {
                    translateElement(ele, "value")
                });
                document.querySelectorAll("[data-i18n-key]").forEach(ele => {
                    translateElement(ele, "key")
                });
                document.querySelectorAll("[data-i18n-theme]").forEach(ele => {
                    let key = themeMode === 2 ? "autoTheme" : themeMode === 1 ? "lightTheme" : "darkTheme";
                    ele.setAttribute("title", translations[locale][key])
                })
                document.querySelectorAll("[data-i18n-window]").forEach(ele => {
                    let key = isFull ? "winedWin" : "fullWin";
                    ele.setAttribute("title", translations[locale][key])
                })
                document.head.children[3].setAttribute("content", translations[locale]["description"])
            };
            initLocale();
            const changeLocale = () => {
                initLocale();
                document.querySelectorAll("[data-type='chatEdit'],[data-type='folderEdit']").forEach(ele => {
                    ele.children[0].textContent = translations[locale]["edit"];
                });
                document.querySelectorAll("[data-type='chatDel'],[data-type='folderDel']").forEach(ele => {
                    ele.children[0].textContent = translations[locale]["del"];
                });
                document.querySelectorAll("[data-type='folderAddChat']").forEach(ele => {
                    ele.children[0].textContent = translations[locale]["newChat"];
                });
                document.querySelectorAll("[data-id]").forEach(ele => {
                    let key = ele.getAttribute("data-id");
                    if (key.endsWith("Md")) {
                        if (key === "speechMd" || key === "pauseMd" || key === "resumeMd") {
                            ele.children[0].textContent = translations[locale][key.slice(0, -2)];
                        } else if (key === "refreshMd") {
                            ele.setAttribute("title", translations[locale][ele.classList.contains("refreshReq") ? "refresh" : "continue"]);
                        } else {
                            ele.setAttribute("title", translations[locale][key.slice(0, -2)]);
                        }
                    }
                });
                document.querySelectorAll(".folderNum").forEach(ele => {
                    let num = ele.textContent.match(/\d+/)[0];
                    ele.textContent = num + translations[locale]["chats"];
                });
                document.querySelectorAll(".u-mdic-copy-btn").forEach(ele => {
                    ele.setAttribute("text", translations[locale]["copyCode"]);
                })
                document.querySelectorAll(".u-mdic-copy-notify").forEach(ele => {
                    ele.setAttribute("text", translations[locale]["copySuccess"]);
                })
                if (editingIdx !== void 0) {
                    document.querySelector("[data-i18n-key='send']").textContent = translations[locale]["update"];
                    document.querySelector("[data-i18n-title='clearChat']").setAttribute("title", translations[locale]["cancel"]);
                }
                loadPrompt();
            }
        </script>
        <script>
            const windowEle = document.getElementsByClassName("chat_window")[0];
            const messagesEle = document.getElementsByClassName("messages")[0];
            const chatlog = document.getElementById("chatlog");
            const stopEle = document.getElementById("stopChat");
            const sendBtnEle = document.getElementById("sendbutton");
            const clearEle = document.getElementsByClassName("clearConv")[0];
            const inputAreaEle = document.getElementById("chatinput");
            const settingEle = document.getElementById("setting");
            const dialogEle = document.getElementById("setDialog");
            const lightEle = document.getElementById("toggleLight");
            const setLightEle = document.getElementById("setLight");
            const autoThemeEle = document.getElementById("autoDetail");
            const systemEle = document.getElementById("systemInput");
            const speechServiceEle = document.getElementById("preSetService");
            const newChatEle = document.getElementById("newChat");
            const folderListEle = document.getElementById("folderList");
            const chatListEle = document.getElementById("chatList");
            const searchChatEle = document.getElementById("searchChat");
            const voiceRecEle = document.getElementById("voiceRecIcon");
            const voiceRecSetEle = document.getElementById("voiceRecSetting");
            const preEle = document.getElementById("preSetSystem");
            let voiceType = 1; // 设置 0: 提问语音，1：回答语音
            let voiceRole = []; // 语音
            let voiceTestText; // 测试语音文本
            let voiceVolume = []; //音量
            let voiceRate = []; // 语速
            let voicePitch = []; // 音调
            let enableContVoice; // 连续朗读
            let enableAutoVoice; // 自动朗读
            let existVoice = 2; // 3:Azure语音 2:使用edge在线语音, 1:使用本地语音, 0:不支持语音
            let azureToken;
            let azureTokenTimer;
            let azureRegion;
            let azureKey;
            let azureRole = [];
            let azureStyle = [];
            const supportSpe = !!(window.speechSynthesis && window.SpeechSynthesisUtterance);
            const isSafeEnv = location.hostname.match(/127.|localhost/) || location.protocol.match(/https:|file:/); // https或本地安全环境
            const supportRec = !!window.webkitSpeechRecognition && isSafeEnv; // 是否支持语音识别输入
            let recing = false;
            let autoSendWord; // 自动发送关键词
            let autoStopWord; // 自动停止关键词
            let autoSendTime; // 自动发送延迟时间
            let keepListenMic; // 保持监听麦克风
            let autoSendTimer;
            let resetRecRes;
            let toggleRecEv;
            const isAndroid = /\bAndroid\b/i.test(navigator.userAgent);
            const isApple = /(Mac|iPhone|iPod|iPad)/i.test(navigator.userAgent);
            const isPWA = navigator.standalone || window.matchMedia("(display-mode: standalone)").matches;
            if (isPWA) {
                let bottomEle = document.querySelector(".bottom_wrapper");
                let footerEle = document.querySelector(".navFooter");
                footerEle.style.marginBottom = bottomEle.style.marginBottom = "8px";
            };
            const dayMs = 8.64e7;
            refreshPage.onclick = () => {
                if (confirmAction(translations[locale]["forceReTip"])) {
                    location.href = location.origin + location.pathname + "?" + new Date().getTime()
                }
            };
            const noLoading = () => {
                return !loading && (!currentResEle || currentResEle.dataset.loading !== "true")
            };
            inputAreaEle.focus();
            const textInputEvent = () => {
                if (noLoading()) sendBtnEle.classList.toggle("activeSendBtn", inputAreaEle.value.trim().length);
                inputAreaEle.style.height = "47px";
                inputAreaEle.style.height = inputAreaEle.scrollHeight + "px";
            };
            inputAreaEle.oninput = textInputEvent;
            const toggleNavEv = () => {
                let isShowNav = document.body.classList.toggle("show-nav");
                if (window.innerWidth > 800) {
                    localStorage.setItem("pinNav", isShowNav)
                }
            }
            document.body.addEventListener("mousedown", event => {
                if (event.target.className === "toggler") {
                    toggleNavEv();
                } else if (event.target.className === "overlay") {
                    document.body.classList.remove("show-nav");
                } else if (event.target === document.body) {
                    if (window.innerWidth <= 800) {
                        document.body.classList.remove("show-nav");
                    }
                }
            });
            const endSetEvent = (ev) => {
                if (!document.getElementById("sysDialog").contains(ev.target)) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    endSet();
                }
            }
            const endSet = () => {
                document.getElementById("sysMask").style.display = "none";
                document.body.removeEventListener("click", endSetEvent, true);
            }
            document.getElementById("closeSet").onclick = endSet;
            document.getElementById("sysSetting").onclick = () => {
                document.getElementById("sysMask").style.display = "flex";
                checkStorage();
                document.getElementById("sysMask").onmousedown = endSetEvent;
            };
            const clearAutoSendTimer = () => {
                if (autoSendTimer !== void 0) {
                    clearTimeout(autoSendTimer);
                    autoSendTimer = void 0;
                }
            }
            const initRecSetting = () => {
                if (supportRec) {
                    noRecTip.style.display = "none";
                    yesRec.style.display = "block";
                    hotKeyVoiceRec.parentElement.style.display = "block";
                    document.getElementById("voiceRec").style.display = "block";
                    inputAreaEle.classList.add("message_if_voice");
                    let langs = [ // from https://www.google.com/intl/en/chrome/demos/speech.html
                        ['中文', ['cmn-Hans-CN', '普通话 (大陆)'],
                            ['cmn-Hans-HK', '普通话 (香港)'],
                            ['cmn-Hant-TW', '中文 (台灣)'],
                            ['yue-Hant-HK', '粵語 (香港)']
                        ],
                        ['English', ['en-US', 'United States'],
                            ['en-GB', 'United Kingdom'],
                            ['en-AU', 'Australia'],
                            ['en-CA', 'Canada'],
                            ['en-IN', 'India'],
                            ['en-KE', 'Kenya'],
                            ['en-TZ', 'Tanzania'],
                            ['en-GH', 'Ghana'],
                            ['en-NZ', 'New Zealand'],
                            ['en-NG', 'Nigeria'],
                            ['en-ZA', 'South Africa'],
                            ['en-PH', 'Philippines']
                        ]
                    ];
                    if (locale !== "zh") langs = langs.reverse();
                    langs.forEach((lang, i) => {
                        select_language.options.add(new Option(lang[0], i));
                        selectLangOption.options.add(new Option(lang[0], i))
                    });
                    const updateCountry = function() {
                        selectLangOption.selectedIndex = select_language.selectedIndex = this.selectedIndex;
                        select_dialect.innerHTML = "";
                        selectDiaOption.innerHTML = "";
                        let list = langs[select_language.selectedIndex];
                        for (let i = 1; i < list.length; i++) {
                            select_dialect.options.add(new Option(list[i][1], list[i][0]));
                            selectDiaOption.options.add(new Option(list[i][1], list[i][0]));
                        }
                        select_dialect.style.visibility = list[1].length == 1 ? "hidden" : "visible";
                        selectDiaOption.parentElement.style.visibility = list[1].length == 1 ? "hidden" : "visible";
                        localStorage.setItem("voiceRecLang", select_dialect.value);
                    };
                    let localLangIdx = 0;
                    let localDiaIdx = 0;
                    let localRecLang = localStorage.getItem("voiceRecLang") || langs[0][1][0];
                    if (localRecLang) {
                        let localIndex = langs.findIndex(item => {
                            let diaIdx = item.findIndex(lang => {
                                return lang instanceof Array && lang[0] === localRecLang
                            });
                            if (diaIdx !== -1) {
                                localDiaIdx = diaIdx - 1;
                                return true;
                            }
                            return false;
                        });
                        if (localIndex !== -1) localLangIdx = localIndex;
                    }
                    selectLangOption.onchange = updateCountry;
                    select_language.onchange = updateCountry;
                    selectDiaOption.onchange = select_dialect.onchange = function() {
                        selectDiaOption.selectedIndex = select_dialect.selectedIndex = this.selectedIndex;
                        localStorage.setItem("voiceRecLang", select_dialect.value);
                    }
                    selectLangOption.selectedIndex = select_language.selectedIndex = localLangIdx;
                    select_language.dispatchEvent(new Event("change"));
                    selectDiaOption.selectedIndex = select_dialect.selectedIndex = localDiaIdx;
                    select_dialect.dispatchEvent(new Event("change"));
                    let localAutoSendWord = localStorage.getItem("autoVoiceSendWord");
                    autoSendWord = autoSendText.value = localAutoSendWord || autoSendText.getAttribute("value") || "";
                    autoSendText.onchange = () => {
                        autoSendWord = autoSendText.value;
                        localStorage.setItem("autoVoiceSendWord", autoSendWord);
                    }
                    autoSendText.dispatchEvent(new Event("change"));
                    let localAutoStopWord = localStorage.getItem("autoVoiceStopWord");
                    autoStopWord = autoStopText.value = localAutoStopWord || autoStopText.getAttribute("value") || "";
                    autoStopText.onchange = () => {
                        autoStopWord = autoStopText.value;
                        localStorage.setItem("autoVoiceStopWord", autoStopWord);
                    }
                    autoStopText.dispatchEvent(new Event("change"));
                    let outEle = document.getElementById("autoSendTimeout");
                    let localTimeout = localStorage.getItem("autoVoiceSendOut");
                    outEle.value = autoSendTime = parseInt(localTimeout || outEle.getAttribute("value"));
                    outEle.oninput = () => {
                        outEle.style.backgroundSize = (outEle.value - outEle.min) * 100 / (outEle.max - outEle.min) + "% 100%";
                        autoSendTime = parseInt(outEle.value);
                        localStorage.setItem("autoVoiceSendOut", outEle.value);
                    }
                    outEle.dispatchEvent(new Event("input"));
                    outEle.onchange = () => {
                        let hasAutoTimer = !!autoSendTimer;
                        clearAutoSendTimer();
                        if (hasAutoTimer) setAutoTimer();
                    }
                    const keepMicEle = document.getElementById("keepListenMic");
                    let localKeepMic = localStorage.getItem("keepListenMic");
                    keepMicEle.checked = keepListenMic = (localKeepMic || keepMicEle.getAttribute("checked")) === "true";
                    keepMicEle.onchange = () => {
                        keepListenMic = keepMicEle.checked;
                        localStorage.setItem("keepListenMic", keepListenMic);
                    }
                    keepMicEle.dispatchEvent(new Event("change"));
                    let recIns = new webkitSpeechRecognition();
                    // prevent some Android bug
                    recIns.continuous = !isAndroid;
                    recIns.interimResults = true;
                    recIns.maxAlternatives = 1;
                    let recRes = tempRes = "";
                    let preRes, affRes;
                    const setAutoTimer = () => {
                        if (autoSendTime) {
                            autoSendTimer = setTimeout(() => {
                                genFunc();
                                autoSendTimer = void 0;
                            }, autoSendTime * 1000);
                        }
                    }
                    const resEvent = (event) => {
                        if (typeof(event.results) === "undefined") {
                            toggleRecEvent();
                            return;
                        }
                        let isFinal;
                        let autoFlag;
                        for (let i = event.resultIndex; i < event.results.length; ++i) {
                            isFinal = event.results[i].isFinal;
                            if (isFinal) {
                                recRes += event.results[i][0].transcript
                                if (autoSendWord) {
                                    let idx = recRes.indexOf(autoSendWord);
                                    if (idx !== -1) {
                                        recRes = recRes.slice(0, idx);
                                        autoFlag = 1;
                                        break;
                                    }
                                }
                                if (autoStopWord) {
                                    let idx = recRes.indexOf(autoStopWord);
                                    if (idx !== -1) {
                                        recRes = recRes.slice(0, idx);
                                        autoFlag = 2;
                                        break;
                                    }
                                }
                            } else {
                                tempRes = recRes + event.results[i][0].transcript
                            }
                        }
                        inputAreaEle.value = preRes + (isFinal ? recRes : tempRes) + affRes;
                        textInputEvent();
                        inputAreaEle.focus();
                        inputAreaEle.selectionEnd = inputAreaEle.value.length - affRes.length;
                        if (autoFlag) {
                            if (autoFlag === 1) genFunc();
                            else endEvent(false, false);
                        }
                        clearAutoSendTimer();
                        if (autoFlag !== 1) setAutoTimer();
                    };
                    resetRecRes = () => {
                        preRes = inputAreaEle.value.slice(0, inputAreaEle.selectionStart);
                        affRes = inputAreaEle.value.slice(inputAreaEle.selectionEnd);
                        recRes = tempRes = "";
                    }
                    const stopAction = () => {
                        clearAutoSendTimer();
                        recIns.onresult = null;
                        recIns.onerror = null;
                        recIns.onend = null;
                        voiceRecEle.classList.remove("voiceRecing");
                        recing = false;
                    }
                    const endEvent = (event, flag) => {
                        if (flag !== void 0) {
                            if (!flag) {
                                recIns.stop();
                                stopAction();
                            }
                        } else if (event) {
                            if (keepListenMic && event.type === "end") {
                                recIns.start();
                                resetRecRes();
                            } else {
                                if (event.type === "error") recIns.stop();
                                stopAction();
                            }
                        }
                    };
                    const errorEvent = (ev) => {
                        if (event.error === "no-speech") {
                            notyf.open({
                                type: "warning",
                                message: translations[locale]["noSpeechTip"]
                            });
                        }
                        if (event.error === "audio-capture") {
                            notyf.error(translations[locale]["noMicTip"])
                            endEvent(ev);
                        }
                        if (event.error === "not-allowed") {
                            notyf.error(translations[locale]["noMicPerTip"])
                            endEvent(ev);
                        }
                    }
                    const closeEvent = (ev) => {
                        if (voiceRecSetEle.contains(ev.target)) return;
                        if (!voiceRecSetEle.contains(ev.target)) {
                            voiceRecSetEle.style.display = "none";
                            document.removeEventListener("mousedown", closeEvent, true);
                            voiceRecEle.classList.remove("voiceLong");
                        }
                    }
                    const longEvent = () => {
                        voiceRecSetEle.style.display = "block";
                        document.addEventListener("mousedown", closeEvent, true);
                    }
                    const toggleRecEvent = () => {
                        if (voiceRecEle.classList.toggle("voiceRecing")) {
                            try {
                                resetRecRes();
                                recIns.lang = select_dialect.value;
                                recIns.start();
                                recIns.onresult = resEvent;
                                recIns.onerror = errorEvent;
                                recIns.onend = endEvent;
                                recing = true;
                            } catch (e) {
                                endEvent(false, false);
                            }
                        } else {
                            endEvent(false, false);
                        }
                    };
                    toggleRecEv = toggleRecEvent;
                    let timer;
                    const voiceDownEvent = (ev) => {
                        ev.preventDefault();
                        let i = 0;
                        voiceRecEle.classList.add("voiceLong");
                        timer = setInterval(() => {
                            i += 1;
                            if (i >= 3) {
                                clearInterval(timer);
                                timer = void 0;
                                longEvent();
                            }
                        }, 100)
                    };
                    const voiceUpEvent = (ev) => {
                        ev.preventDefault();
                        if (timer !== void 0) {
                            toggleRecEvent();
                            clearInterval(timer);
                            timer = void 0;
                            voiceRecEle.classList.remove("voiceLong");
                        }
                    }
                    voiceRecEle.onmousedown = voiceDownEvent;
                    voiceRecEle.ontouchstart = voiceDownEvent;
                    voiceRecEle.onmouseup = voiceUpEvent;
                    voiceRecEle.ontouchend = voiceUpEvent;
                };
            };
            initRecSetting();
            document.querySelector(".sysSwitch").onclick = document.querySelector(".setSwitch").onclick = function(ev) {
                let activeEle = this.getElementsByClassName("activeSwitch")[0];
                if (ev.target !== activeEle) {
                    activeEle.classList.remove("activeSwitch");
                    ev.target.classList.add("activeSwitch");
                    document.getElementById(ev.target.dataset.id).style.display = "block";
                    document.getElementById(activeEle.dataset.id).style.display = "none";
                }
            };
            if (!supportSpe) {
                speechServiceEle.remove(2);
            }
            const initVoiceVal = () => {
                let localVoiceType = localStorage.getItem("existVoice");
                speechServiceEle.value = existVoice = parseInt(localVoiceType || "2");
            }
            initVoiceVal();
            const clearAzureVoice = () => {
                azureKey = void 0;
                azureRegion = void 0;
                azureRole = [];
                azureStyle = [];
                document.getElementById("azureExtra").style.display = "none";
                azureKeyInput.parentElement.style.display = "none";
                preSetAzureRegion.parentElement.style.display = "none";
                if (azureTokenTimer) {
                    clearInterval(azureTokenTimer);
                    azureTokenTimer = void 0;
                }
            }
            speechServiceEle.onchange = () => {
                existVoice = parseInt(speechServiceEle.value);
                localStorage.setItem("existVoice", existVoice);
                toggleVoiceCheck(true);
                if (checkAzureAbort && !checkAzureAbort.signal.aborted) {
                    checkAzureAbort.abort();
                    checkAzureAbort = void 0;
                }
                if (checkEdgeAbort && !checkEdgeAbort.signal.aborted) {
                    checkEdgeAbort.abort();
                    checkEdgeAbort = void 0;
                }
                if (existVoice === 3) {
                    azureKeyInput.parentElement.style.display = "block";
                    preSetAzureRegion.parentElement.style.display = "block";
                    loadAzureVoice();
                } else if (existVoice === 2) {
                    clearAzureVoice();
                    loadEdgeVoice();
                } else if (existVoice === 1) {
                    toggleVoiceCheck(false);
                    clearAzureVoice();
                    loadLocalVoice();
                }
            }
            let azureVoiceData, edgeVoiceData, systemVoiceData, checkAzureAbort, checkEdgeAbort;
            const toggleVoiceCheck = (bool) => {
                checkVoiceLoad.style.display = bool ? "flex" : "none";
                speechDetail.style.display = bool ? "none" : "block";
            }
            const loadAzureVoice = () => {
                let checking = false;
                const checkAzureFunc = () => {
                    if (checking) return;
                    if (azureKey) {
                        checking = true;
                        checkVoiceLoad.classList.add("voiceChecking");
                        if (azureTokenTimer) {
                            clearInterval(azureTokenTimer);
                        }
                        checkAzureAbort = new AbortController();
                        setTimeout(() => {
                            if (checkAzureAbort && !checkAzureAbort.signal.aborted) {
                                checkAzureAbort.abort();
                                checkAzureAbort = void 0;
                            }
                        }, 15000);
                        Promise.all([getAzureToken(checkAzureAbort.signal), getVoiceList(checkAzureAbort.signal)]).then(() => {
                            azureTokenTimer = setInterval(() => {
                                getAzureToken();
                            }, 540000);
                            toggleVoiceCheck(false);
                        }).catch(e => {}).finally(() => {
                            checkVoiceLoad.classList.remove("voiceChecking");
                            checking = false;
                        })
                    }
                };
                checkVoiceLoad.onclick = checkAzureFunc;
                const getAzureToken = (signal) => {
                    return new Promise((res, rej) => {
                        fetch("https://" + azureRegion + ".api.cognitive.microsoft.com/sts/v1.0/issueToken", {
                            signal,
                            method: "POST",
                            headers: {
                                "Ocp-Apim-Subscription-Key": azureKey
                            }
                        }).then(response => {
                            response.text().then(text => {
                                try {
                                    let json = JSON.parse(text);
                                    notyf.error(translations[locale]["azureInvalidTip"]);
                                    rej();
                                } catch (e) {
                                    azureToken = text;
                                    res();
                                }
                            });
                        }).catch(e => {
                            rej();
                        })
                    })
                };
                const getVoiceList = (signal) => {
                    return new Promise((res, rej) => {
                        if (azureVoiceData) {
                            initVoiceSetting(azureVoiceData);
                            res();
                        } else {
                            let localAzureVoiceData = localStorage.getItem(azureRegion + "voiceData");
                            if (localAzureVoiceData) {
                                azureVoiceData = JSON.parse(localAzureVoiceData);
                                initVoiceSetting(azureVoiceData);
                                res();
                            } else {
                                fetch("https://" + azureRegion + ".tts.speech.microsoft.com/cognitiveservices/voices/list", {
                                    signal,
                                    headers: {
                                        "Ocp-Apim-Subscription-Key": azureKey
                                    }
                                }).then(response => {
                                    response.json().then(json => {
                                        azureVoiceData = json;
                                        localStorage.setItem(azureRegion + "voiceData", JSON.stringify(json));
                                        initVoiceSetting(json);
                                        res();
                                    }).catch(e => {
                                        notyf.error(translations[locale]["azureInvalidTip"]);
                                        rej();
                                    })
                                }).catch(e => {
                                    rej();
                                })
                            }
                        }
                    })
                };
                let azureRegionEle = document.getElementById("preSetAzureRegion");
                if (!azureRegionEle.options.length) {
                    const azureRegions = ['southafricanorth', 'eastasia', 'southeastasia', 'australiaeast', 'centralindia', 'japaneast', 'japanwest', 'koreacentral', 'canadacentral', 'northeurope', 'westeurope', 'francecentral', 'germanywestcentral', 'norwayeast', 'switzerlandnorth', 'switzerlandwest', 'uksouth', 'uaenorth', 'brazilsouth', 'centralus', 'eastus', 'eastus2', 'northcentralus', 'southcentralus', 'westcentralus', 'westus', 'westus2', 'westus3'];
                    azureRegions.forEach((region, i) => {
                        let option = document.createElement("option");
                        option.value = region;
                        option.text = region;
                        azureRegionEle.options.add(option);
                    });
                }
                let localAzureRegion = localStorage.getItem("azureRegion");
                if (localAzureRegion) {
                    azureRegion = localAzureRegion;
                    azureRegionEle.value = localAzureRegion;
                }
                azureRegionEle.onchange = () => {
                    azureRegion = azureRegionEle.value;
                    localStorage.setItem("azureRegion", azureRegion);
                    toggleVoiceCheck(true);
                }
                azureRegionEle.dispatchEvent(new Event("change"));
                let azureKeyEle = document.getElementById("azureKeyInput");
                let localAzureKey = localStorage.getItem("azureKey");
                if (localAzureKey) {
                    azureKey = localAzureKey;
                    azureKeyEle.value = localAzureKey;
                }
                azureKeyEle.onchange = () => {
                    azureKey = azureKeyEle.value;
                    localStorage.setItem("azureKey", azureKey);
                    toggleVoiceCheck(true);
                }
                azureKeyEle.dispatchEvent(new Event("change"));
                if (azureKey) {
                    checkAzureFunc();
                }
            }
            const loadEdgeVoice = () => {
                let checking = false;
                const endCheck = () => {
                    checkVoiceLoad.classList.remove("voiceChecking");
                    checking = false;
                };
                const checkEdgeFunc = () => {
                    if (checking) return;
                    checking = true;
                    checkVoiceLoad.classList.add("voiceChecking");
                    if (edgeVoiceData) {
                        initVoiceSetting(edgeVoiceData);
                        toggleVoiceCheck(false);
                        endCheck();
                    } else {
                        checkEdgeAbort = new AbortController();
                        setTimeout(() => {
                            if (checkEdgeAbort && !checkEdgeAbort.signal.aborted) {
                                checkEdgeAbort.abort();
                                checkEdgeAbort = void 0;
                            }
                        }, 10000);
                        fetch("https://speech.platform.bing.com/consumer/speech/synthesize/readaloud/voices/list?trustedclienttoken=6A5AA1D4EAFF4E9FB37E23D68491D6F4", {
                            signal: checkEdgeAbort.signal
                        }).then(response => {
                            response.json().then(json => {
                                edgeVoiceData = json;
                                toggleVoiceCheck(false);
                                initVoiceSetting(json);
                                endCheck();
                            });
                        }).catch(err => {
                            endCheck();
                        })
                    }
                };
                checkEdgeFunc();
                checkVoiceLoad.onclick = checkEdgeFunc;
            };
            const loadLocalVoice = () => {
                if (systemVoiceData) {
                    initVoiceSetting(systemVoiceData);
                } else {
                    let initedVoice = false;
                    const getLocalVoice = () => {
                        let voices = speechSynthesis.getVoices();
                        if (voices.length) {
                            if (!initedVoice) {
                                initedVoice = true;
                                systemVoiceData = voices;
                                initVoiceSetting(voices);
                            }
                            return true;
                        } else {
                            return false;
                        }
                    }
                    let syncExist = getLocalVoice();
                    if (!syncExist) {
                        if ("onvoiceschanged" in speechSynthesis) {
                            speechSynthesis.onvoiceschanged = () => {
                                getLocalVoice();
                            }
                        } else if (speechSynthesis.addEventListener) {
                            speechSynthesis.addEventListener("voiceschanged", () => {
                                getLocalVoice();
                            })
                        }
                        let timeout = 0;
                        let timer = setInterval(() => {
                            if (getLocalVoice() || timeout > 1000) {
                                if (timeout > 1000) {
                                    existVoice = 0;
                                }
                                clearInterval(timer);
                                timer = null;
                            }
                            timeout += 300;
                        }, 300)
                    }
                }
            };
            const initVoiceSetting = (voices) => {
                let isOnline = existVoice >= 2;
                let voicesEle = document.getElementById("preSetSpeech");
                // 支持中文和英文
                voices = isOnline ? voices.filter(item => item.Locale.match(/^(zh-|en-)/)) : voices.filter(item => item.lang.match(/^(zh-|en-)/));
                if (isOnline) {
                    voices.map(item => {
                        item.name = item.FriendlyName || (`${item.DisplayName} Online (${item.VoiceType}) - ${item.LocaleName}`);
                        item.lang = item.Locale;
                    })
                }
                voices.sort((a, b) => {
                    if (a.lang.slice(0, 2) === b.lang.slice(0, 2)) {
                        if (a.lang.slice(0, 2) === "zh") {
                            return (a.lang === b.lang) ? 0 : (a.lang > b.lang) ? 1 : -1; // zh-CN 在前
                        } else {
                            return 0
                        }
                    }
                    return (locale === "zh" ? (a.lang < b.lang) : (a.lang > b.lang)) ? 1 : -1; // 中文UI，则中文"z"在前
                });
                voices.map(item => {
                    if (item.name.match(/^(Google |Microsoft )/)) {
                        item.displayName = item.name.replace(/^.*? /, "");
                    } else {
                        item.displayName = item.name;
                    }
                });
                voicesEle.innerHTML = "";
                voices.forEach((voice, i) => {
                    let option = document.createElement("option");
                    option.value = i;
                    option.text = voice.displayName;
                    voicesEle.options.add(option);
                });
                voicesEle.onchange = () => {
                    voiceRole[voiceType] = voices[voicesEle.value];
                    localStorage.setItem("voice" + voiceType, voiceRole[voiceType].name);
                    if (voiceRole[voiceType].StyleList || voiceRole[voiceType].RolePlayList) {
                        document.getElementById("azureExtra").style.display = "block";
                        let voiceStyles = voiceRole[voiceType].StyleList;
                        let voiceRoles = voiceRole[voiceType].RolePlayList;
                        if (voiceRoles) {
                            preSetVoiceRole.innerHTML = "";
                            voiceRoles.forEach((role, i) => {
                                let option = document.createElement("option");
                                option.value = role;
                                option.text = role;
                                preSetVoiceRole.options.add(option);
                            });
                            let localRole = localStorage.getItem("azureRole" + voiceType);
                            if (localRole && voiceRoles.indexOf(localRole) !== -1) {
                                preSetVoiceRole.value = localRole;
                                azureRole[voiceType] = localRole;
                            } else {
                                preSetVoiceRole.selectedIndex = 0;
                                azureRole[voiceType] = voiceRole[0];
                            }
                            preSetVoiceRole.onchange = () => {
                                azureRole[voiceType] = preSetVoiceRole.value;
                                localStorage.setItem("azureRole" + voiceType, preSetVoiceRole.value);
                            }
                            preSetVoiceRole.dispatchEvent(new Event("change"));
                        } else {
                            azureRole[voiceType] = void 0;
                            localStorage.removeItem("azureRole" + voiceType);
                        }
                        preSetVoiceRole.style.display = voiceRoles ? "block" : "none";
                        preSetVoiceRole.previousElementSibling.style.display = voiceRoles ? "block" : "none";
                        if (voiceStyles) {
                            preSetVoiceStyle.innerHTML = "";
                            voiceStyles.forEach((style, i) => {
                                let option = document.createElement("option");
                                option.value = style;
                                option.text = style;
                                preSetVoiceStyle.options.add(option);
                            });
                            let localStyle = localStorage.getItem("azureStyle" + voiceType);
                            if (localStyle && voiceStyles.indexOf(localStyle) !== -1) {
                                preSetVoiceStyle.value = localStyle;
                                azureStyle[voiceType] = localStyle;
                            } else {
                                preSetVoiceStyle.selectedIndex = 0;
                                azureStyle[voiceType] = voiceStyles[0];
                            }
                            preSetVoiceStyle.onchange = () => {
                                azureStyle[voiceType] = preSetVoiceStyle.value;
                                localStorage.setItem("azureStyle" + voiceType, preSetVoiceStyle.value)
                            }
                            preSetVoiceStyle.dispatchEvent(new Event("change"));
                        } else {
                            azureStyle[voiceType] = void 0;
                            localStorage.removeItem("azureStyle" + voiceType);
                        }
                        preSetVoiceStyle.style.display = voiceStyles ? "block" : "none";
                        preSetVoiceStyle.previousElementSibling.style.display = voiceStyles ? "block" : "none";
                    } else {
                        document.getElementById("azureExtra").style.display = "none";
                        azureRole[voiceType] = void 0;
                        localStorage.removeItem("azureRole" + voiceType);
                        azureStyle[voiceType] = void 0;
                        localStorage.removeItem("azureStyle" + voiceType);
                    }
                };
                const loadAnother = (type) => {
                    type = type ^ 1;
                    let localVoice = localStorage.getItem("voice" + type);
                    if (localVoice) {
                        let localIndex = voices.findIndex(item => {
                            return item.name === localVoice
                        });
                        if (localIndex === -1) localIndex = 0;
                        voiceRole[type] = voices[localIndex];
                    } else {
                        voiceRole[type] = voices[0];
                    }
                    if (existVoice === 3) {
                        let localStyle = localStorage.getItem("azureStyle" + type);
                        azureStyle[type] = localStyle ? localStyle : void 0;
                        let localRole = localStorage.getItem("azureRole" + type);
                        azureRole[type] = localRole ? localRole : void 0;
                    }
                }
                const voiceChange = () => {
                    let localVoice = localStorage.getItem("voice" + voiceType);
                    if (localVoice) {
                        let localIndex = voices.findIndex(item => {
                            return item.name === localVoice
                        });
                        if (localIndex === -1) localIndex = 0;
                        voiceRole[voiceType] = voices[localIndex];
                        voicesEle.value = localIndex;
                    } else {
                        voiceRole[voiceType] = voices[0];
                    }
                    voicesEle.dispatchEvent(new Event("change"));
                }
                voiceChange();
                loadAnother(voiceType);
                let volumeEle = document.getElementById("voiceVolume");
                let localVolume = localStorage.getItem("voiceVolume0");
                voiceVolume[0] = parseFloat(localVolume || volumeEle.getAttribute("value"));
                const voiceVolumeChange = () => {
                    let localVolume = localStorage.getItem("voiceVolume" + voiceType);
                    volumeEle.value = voiceVolume[voiceType] = parseFloat(localVolume || volumeEle.getAttribute("value"));
                    volumeEle.style.backgroundSize = (volumeEle.value - volumeEle.min) * 100 / (volumeEle.max - volumeEle.min) + "% 100%";
                }
                volumeEle.oninput = () => {
                    volumeEle.style.backgroundSize = (volumeEle.value - volumeEle.min) * 100 / (volumeEle.max - volumeEle.min) + "% 100%";
                    voiceVolume[voiceType] = parseFloat(volumeEle.value);
                    localStorage.setItem("voiceVolume" + voiceType, volumeEle.value);
                }
                voiceVolumeChange();
                let rateEle = document.getElementById("voiceRate");
                let localRate = localStorage.getItem("voiceRate0");
                voiceRate[0] = parseFloat(localRate || rateEle.getAttribute("value"));
                const voiceRateChange = () => {
                    let localRate = localStorage.getItem("voiceRate" + voiceType);
                    rateEle.value = voiceRate[voiceType] = parseFloat(localRate || rateEle.getAttribute("value"));
                    rateEle.style.backgroundSize = (rateEle.value - rateEle.min) * 100 / (rateEle.max - rateEle.min) + "% 100%";
                }
                rateEle.oninput = () => {
                    rateEle.style.backgroundSize = (rateEle.value - rateEle.min) * 100 / (rateEle.max - rateEle.min) + "% 100%";
                    voiceRate[voiceType] = parseFloat(rateEle.value);
                    localStorage.setItem("voiceRate" + voiceType, rateEle.value);
                }
                voiceRateChange();
                let pitchEle = document.getElementById("voicePitch");
                let localPitch = localStorage.getItem("voicePitch0");
                voicePitch[0] = parseFloat(localPitch || pitchEle.getAttribute("value"));
                const voicePitchChange = () => {
                    let localPitch = localStorage.getItem("voicePitch" + voiceType);
                    pitchEle.value = voicePitch[voiceType] = parseFloat(localPitch || pitchEle.getAttribute("value"));
                    pitchEle.style.backgroundSize = (pitchEle.value - pitchEle.min) * 100 / (pitchEle.max - pitchEle.min) + "% 100%";
                }
                pitchEle.oninput = () => {
                    pitchEle.style.backgroundSize = (pitchEle.value - pitchEle.min) * 100 / (pitchEle.max - pitchEle.min) + "% 100%";
                    voicePitch[voiceType] = parseFloat(pitchEle.value);
                    localStorage.setItem("voicePitch" + voiceType, pitchEle.value);
                }
                voicePitchChange();
                document.getElementById("voiceTypes").onclick = (ev) => {
                    let type = ev.target.dataset.type;
                    if (type !== void 0) {
                        type = parseInt(type);
                        if (type != voiceType) {
                            voiceType = type;
                            ev.target.classList.add("selVoiceType");
                            ev.target.parentElement.children[type ^ 1].classList.remove("selVoiceType");
                            voiceChange();
                            voiceVolumeChange();
                            voiceRateChange();
                            voicePitchChange();
                        }
                    };
                };
                const voiceTestEle = document.getElementById("testVoiceText");
                let localTestVoice = localStorage.getItem("voiceTestText");
                voiceTestText = voiceTestEle.value = localTestVoice || voiceTestEle.getAttribute("value");
                voiceTestEle.oninput = () => {
                    voiceTestText = voiceTestEle.value;
                    localStorage.setItem("voiceTestText", voiceTestText);
                }
                const contVoiceEle = document.getElementById("enableContVoice");
                let localCont = localStorage.getItem("enableContVoice");
                contVoiceEle.checked = enableContVoice = (localCont || contVoiceEle.getAttribute("checked")) === "true";
                contVoiceEle.onchange = () => {
                    enableContVoice = contVoiceEle.checked;
                    localStorage.setItem("enableContVoice", enableContVoice);
                }
                contVoiceEle.dispatchEvent(new Event("change"));
                const autoVoiceEle = document.getElementById("enableAutoVoice");
                let localAuto = localStorage.getItem("enableAutoVoice");
                autoVoiceEle.checked = enableAutoVoice = (localAuto || autoVoiceEle.getAttribute("checked")) === "true";
                autoVoiceEle.onchange = () => {
                    enableAutoVoice = autoVoiceEle.checked;
                    localStorage.setItem("enableAutoVoice", enableAutoVoice);
                }
                autoVoiceEle.dispatchEvent(new Event("change"));
            };
            speechServiceEle.dispatchEvent(new Event("change"));
        </script>
        <script crossorigin="anonymous" src="//cdn.staticfile.org/markdown-it/13.0.2/markdown-it.min.js"></script>
        <script crossorigin="anonymous" src="//cdn.staticfile.org/highlight.js/11.9.0/highlight.min.js"></script>
        <script crossorigin="anonymous" src="//cdn.staticfile.org/KaTeX/0.16.9/katex.min.js"></script>
        <script>
            // from markdown-it-texmath@1.0.0
            function escapeHTML(e) {
                return e.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;")
            }

            function texmath(e, t) {
                const n = texmath.mergeDelimiters(t && t.delimiters),
                    a = t && t.outerSpace || !1,
                    o = t && t.katexOptions || {};
                o.throwOnError = o.throwOnError || !1, o.macros = o.macros || t && t.macros, texmath.katex || (t && "object" == typeof t.engine ? texmath.katex = t.engine : "object" == typeof module ? texmath.katex = require("katex") : texmath.katex = {
                    renderToString: () => "No math renderer found."
                });
                for (const t of n.inline) a && "outerSpace" in t && (t.outerSpace = !0), e.inline.ruler.before("escape", t.name, texmath.inline(t)), e.renderer.rules[t.name] = (e, n) => t.tmpl.replace(/\$1/, texmath.render(e[n].content, !!t.displayMode, o));
                for (const t of n.block) e.block.ruler.before("fence", t.name, texmath.block(t)), e.renderer.rules[t.name] = (e, n) => t.tmpl.replace(/\$2/, escapeHTML(e[n].info)).replace(/\$1/, texmath.render(e[n].content, !0, o))
            }
            texmath.mergeDelimiters = function(e) {
                const t = Array.isArray(e) ? e : "string" == typeof e ? [e] : ["dollars"],
                    n = {
                        inline: [],
                        block: []
                    };
                for (const e of t) e in texmath.rules && (n.inline.push(...texmath.rules[e].inline), n.block.push(...texmath.rules[e].block));
                return n
            }, texmath.inline = e => function(t, n) {
                const a = t.pos,
                    o = t.src,
                    r = o.startsWith(e.tag, e.rex.lastIndex = a) && (!e.pre || e.pre(o, e.outerSpace, a)) && e.rex.exec(o),
                    s = !!r && a < e.rex.lastIndex && (!e.post || e.post(o, e.outerSpace, e.rex.lastIndex - 1));
                if (s) {
                    if (!n) {
                        const n = t.push(e.name, "math", 0);
                        n.content = r[1], n.markup = e.tag
                    }
                    t.pos = e.rex.lastIndex
                }
                return s
            }, texmath.block = e => function(t, n, a, o) {
                const r = t.bMarks[n] + t.tShift[n],
                    s = t.src,
                    m = s.startsWith(e.tag, e.rex.lastIndex = r) && (!e.pre || e.pre(s, !1, r)) && e.rex.exec(s),
                    l = !!m && r < e.rex.lastIndex && (!e.post || e.post(s, !1, e.rex.lastIndex - 1));
                if (l && !o) {
                    const o = e.rex.lastIndex - 1;
                    let r;
                    for (r = n; r < a && !(o >= t.bMarks[r] + t.tShift[r] && o <= t.eMarks[r]); r++);
                    const s = t.lineMax,
                        l = t.parentType;
                    t.lineMax = r, t.parentType = "math", "blockquote" === l && (m[1] = m[1].replace(/(\n*?^(?:\s*>)+)/gm, ""));
                    let c = t.push(e.name, "math", 0);
                    c.block = !0, c.tag = e.tag, c.markup = "", c.content = m[1], c.info = m[m.length - 1], c.map = [n, r + 1], t.parentType = l, t.lineMax = s, t.line = r + 1
                }
                return l
            }, texmath.render = function(e, t, n) {
                let a;
                n.displayMode = t;
                try {
                    a = texmath.katex.renderToString(e, n)
                } catch (t) {
                    a = escapeHTML(`${e}:${t.message}`)
                }
                return a
            }, texmath.inlineRuleNames = ["math_inline", "math_inline_double"], texmath.blockRuleNames = ["math_block", "math_block_eqno"], texmath.$_pre = (e, t, n) => {
                const a = n > 0 && e[n - 1].charCodeAt(0);
                return t ? !a || 32 === a : !a || 92 !== a && (a < 48 || a > 57)
            }, texmath.$_post = (e, t, n) => {
                const a = e[n + 1] && e[n + 1].charCodeAt(0);
                return t ? !a || 32 === a || 46 === a || 44 === a || 59 === a : !a || a < 48 || a > 57
            }, texmath.rules = {
                brackets: {
                    inline: [{
                        name: "math_inline",
                        rex: /\\\((.+?)\\\)/gy,
                        tmpl: "<eq>$1</eq>",
                        tag: "\\("
                    }],
                    block: [{
                        name: "math_block_eqno",
                        rex: /\\\[(((?!\\\]|\\\[)[\s\S])+?)\\\]\s*?\(([^)$\r\n]+?)\)/gmy,
                        tmpl: '<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',
                        tag: "\\["
                    }, {
                        name: "math_block",
                        rex: /\\\[([\s\S]+?)\\\]/gmy,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "\\["
                    }]
                },
                doxygen: {
                    inline: [{
                        name: "math_inline",
                        rex: /\\f\$(.+?)\\f\$/gy,
                        tmpl: "<eq>$1</eq>",
                        tag: "\\f$"
                    }],
                    block: [{
                        name: "math_block_eqno",
                        rex: /\\f\[([^]+?)\\f\]\s*?\(([^)\s]+?)\)/gmy,
                        tmpl: '<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',
                        tag: "\\f["
                    }, {
                        name: "math_block",
                        rex: /\\f\[([^]+?)\\f\]/gmy,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "\\f["
                    }]
                },
                gitlab: {
                    inline: [{
                        name: "math_inline",
                        rex: /\$`(.+?)`\$/gy,
                        tmpl: "<eq>$1</eq>",
                        tag: "$`"
                    }],
                    block: [{
                        name: "math_block_eqno",
                        rex: /`{3}math\s*([^`]+?)\s*?`{3}\s*\(([^)\r\n]+?)\)/gm,
                        tmpl: '<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',
                        tag: "```math"
                    }, {
                        name: "math_block",
                        rex: /`{3}math\s*([^`]*?)\s*`{3}/gm,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "```math"
                    }]
                },
                julia: {
                    inline: [{
                        name: "math_inline",
                        rex: /`{2}([^`]+?)`{2}/gy,
                        tmpl: "<eq>$1</eq>",
                        tag: "``"
                    }, {
                        name: "math_inline",
                        rex: /\$((?:\S?)|(?:\S.*?\S))\$/gy,
                        tmpl: "<eq>$1</eq>",
                        tag: "$",
                        spaceEnclosed: !1,
                        pre: texmath.$_pre,
                        post: texmath.$_post
                    }],
                    block: [{
                        name: "math_block_eqno",
                        rex: /`{3}math\s+?([^`]+?)\s+?`{3}\s*?\(([^)$\r\n]+?)\)/gmy,
                        tmpl: '<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',
                        tag: "```math"
                    }, {
                        name: "math_block",
                        rex: /`{3}math\s+?([^`]+?)\s+?`{3}/gmy,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "```math"
                    }]
                },
                kramdown: {
                    inline: [{
                        name: "math_inline",
                        rex: /\${2}(.+?)\${2}/gy,
                        tmpl: "<eq>$1</eq>",
                        tag: "$$"
                    }],
                    block: [{
                        name: "math_block_eqno",
                        rex: /\${2}([^$]+?)\${2}\s*?\(([^)\s]+?)\)/gmy,
                        tmpl: '<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',
                        tag: "$$"
                    }, {
                        name: "math_block",
                        rex: /\${2}([^$]+?)\${2}/gmy,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "$$"
                    }]
                },
                beg_end: {
                    inline: [],
                    block: [{
                        name: "math_block",
                        rex: /(\\(?:begin)\{([a-z]+)\}[\s\S]+?\\(?:end)\{\2\})/gmy,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "\\"
                    }]
                },
                dollars: {
                    inline: [{
                        name: "math_inline_double",
                        rex: /\${2}([^$]*?[^\\])\${2}/gy,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "$$",
                        displayMode: !0,
                        pre: texmath.$_pre,
                        post: texmath.$_post
                    }, {
                        name: "math_inline",
                        rex: /\$((?:[^\s\\])|(?:\S.*?[^\s\\]))\$/gy,
                        tmpl: "<eq>$1</eq>",
                        tag: "$",
                        outerSpace: !1,
                        pre: texmath.$_pre,
                        post: texmath.$_post
                    }],
                    block: [{
                        name: "math_block_eqno",
                        rex: /\${2}([^$]*?[^\\])\${2}\s*?\(([^)\s]+?)\)/gmy,
                        tmpl: '<section class="eqno"><eqn>$1</eqn><span>($2)</span></section>',
                        tag: "$$"
                    }, {
                        name: "math_block",
                        rex: /\${2}([^$]*?[^\\])\${2}/gmy,
                        tmpl: "<section><eqn>$1</eqn></section>",
                        tag: "$$"
                    }]
                }
            };
        </script>
        <script>
            const API_URL = "v1/chat/completions";
            let loading = false;
            let presetRoleData = {
                "default": translations[locale]["defaultText"],
                "normal": translations[locale]["assistantText"],
                "cat": translations[locale]["catText"],
                "emoji": translations[locale]["emojiText"],
                "image": translations[locale]["imageText"]
            };
            let modelVersion; // 模型版本
            let apiHost; // 反代地址
            let apiSelects = []; // api地址列表
            let customAPIKey; // 自定义apiKey
            let systemRole; // 自定义系统角色
            let roleNature; // 角色性格
            let roleTemp; // 回答质量
            let convWidth = []; // 会话宽度，0:窗口宽度，1:全屏宽度
            let textSpeed; // 打字机速度，越小越快
            let contLen; // 连续会话长度，默认25，对话包含25条上下文信息。设置为0即关闭连续会话
            let enableLongReply; // 是否开启长回复，默认关闭，开启可能导致api费用增加。
            let longReplyFlag;
            let voiceIns; // Audio or SpeechSynthesisUtterance
            const isFirefox = !!navigator.userAgent.match(/firefox/i);
            const supportMSE = !!window.MediaSource && !isFirefox; // 是否支持MSE（除了ios应该都支持）
            const voiceMIME = "audio/mpeg";
            const voiceFormat = "audio-24khz-48kbitrate-mono-mp3";
            const voicePreLen = 130;
            const voiceSuffix = ".mp3";
            let userAvatar; // 用户头像
            let customDarkOut;
            let isCaseSearch; // 搜索是否区分大小写
            let controller;
            let controllerId;
            const findOffsetTop = (ele, target) => { // target is positioned ancestor element
                if (ele.offsetParent !== target) return ele.offsetTop + findOffsetTop(ele.offsetParent, target);
                else return ele.offsetTop;
            }
            const findResEle = (ele) => {
                if (!ele.classList.contains("response")) return findResEle(ele.parentElement);
                else return ele;
            }
            const isContentBottom = (ele) => {
                if (refreshIdx !== void 0) {
                    return currentResEle.clientHeight + currentResEle.offsetTop > messagesEle.scrollTop + messagesEle.clientHeight
                } else {
                    return messagesEle.scrollHeight - messagesEle.scrollTop - messagesEle.clientHeight < 128;
                }
            }
            const isEleBottom = (ele) => {
                return ele.clientHeight + findOffsetTop(ele, messagesEle) > messagesEle.scrollTop + messagesEle.clientHeight;
            }
            const outOfMsgWindow = (ele) => {
                return ele.offsetTop > messagesEle.scrollTop + messagesEle.clientHeight || ele.offsetTop + ele.clientHeight < messagesEle.scrollTop
            }
            const scrollToBottom = () => {
                if (isContentBottom()) {
                    if (refreshIdx !== void 0) {
                        messagesEle.scrollTo(0, currentResEle.clientHeight + currentResEle.offsetTop - messagesEle.clientHeight + 10)
                    } else {
                        messagesEle.scrollTo(0, messagesEle.scrollHeight)
                    }
                }
            }
            const scrollToBottomLoad = (ele) => {
                if (!controller || !ele.offsetParent) return;
                if (isEleBottom(ele)) {
                    let resEle = findResEle(ele)
                    messagesEle.scrollTo(0, resEle.clientHeight + resEle.offsetTop - messagesEle.clientHeight + 10)
                }
            }
            const forceRepaint = (ele) => {
                ele.style.display = "none";
                ele.offsetHeight;
                ele.style.display = null;
            }
            const escapeTextarea = document.createElement("textarea");
            const getEscape = str => {
                escapeTextarea.textContent = str;
                return escapeTextarea.innerHTML;
            }
            const parser = new DOMParser();
            const getUnescape = html => {
                return parser.parseFromString(html, 'text/html').body.textContent;
            }
            const escapeRegexExp = (str) => { // from vscode src/vs/base/common/strings.ts escapeRegExpCharacters
                return str.replace(/[\\\{\}\*\+\?\|\^\$\.\[\]\(\)]/g, '\\$&');
            }
            const checkStorage = () => {
                let used = 0;
                for (let key in localStorage) {
                    localStorage.hasOwnProperty(key) && (used += localStorage[key].length)
                }
                let remain = 5242880 - used;
                usedStorageBar.style.width = (used / 5242880 * 100).toFixed(2) + "%";
                let usedMBs = used / 1048576;
                usedStorage.textContent = (usedMBs < 1 ? usedMBs.toPrecision(2) : usedMBs.toFixed(2)) + "MB";
                availableStorage.textContent = Math.floor(remain / 1048576 * 100) / 100 + "MB";
            };
            const UNESCAPE_RE = /\\([ \\!"#$%&'()*+,.\/:;<=>?@[\]^_`{|}~-])/g;
            const superscript = (state, silent) => {
                let found,
                    content,
                    token,
                    max = state.posMax,
                    start = state.pos;
                if (state.src.charCodeAt(start) !== 0x5E /* ^ */ ) {
                    return false;
                }
                if (silent) {
                    return false;
                } // don't run any pairs in validation mode
                if (start + 2 >= max) {
                    return false;
                }
                state.pos = start + 1;
                while (state.pos < max) {
                    if (state.src.charCodeAt(state.pos) === 0x5E /* ^ */ ) {
                        found = true;
                        break;
                    }
                    state.md.inline.skipToken(state);
                }
                if (!found || start + 1 === state.pos) {
                    state.pos = start;
                    return false;
                }
                content = state.src.slice(start + 1, state.pos);
                // don't allow unescaped spaces/newlines inside
                if (content.match(/(^|[^\\])(\\\\)*\s/)) {
                    state.pos = start;
                    return false;
                }
                // found!
                state.posMax = state.pos;
                state.pos = start + 1;
                // Earlier we checked !silent, but this implementation does not need it
                token = state.push('sup_open', 'sup', 1);
                token.markup = '^';
                token = state.push('text', '', 0);
                token.content = content.replace(UNESCAPE_RE, '$1');
                token = state.push('sup_close', 'sup', -1);
                token.markup = '^';
                state.pos = state.posMax + 1;
                state.posMax = max;
                return true;
            }
            const subscript = (state, silent) => {
                let found,
                    content,
                    token,
                    max = state.posMax,
                    start = state.pos;
                if (state.src.charCodeAt(start) !== 0x7E /* ~ */ ) {
                    return false;
                }
                if (silent) {
                    return false;
                } // don't run any pairs in validation mode
                if (start + 2 >= max) {
                    return false;
                }
                state.pos = start + 1;
                while (state.pos < max) {
                    if (state.src.charCodeAt(state.pos) === 0x7E /* ~ */ ) {
                        found = true;
                        break;
                    }
                    state.md.inline.skipToken(state);
                }
                if (!found || start + 1 === state.pos) {
                    state.pos = start;
                    return false;
                }
                content = state.src.slice(start + 1, state.pos);
                // don't allow unescaped spaces/newlines inside
                if (content.match(/(^|[^\\])(\\\\)*\s/)) {
                    state.pos = start;
                    return false;
                }
                // found!
                state.posMax = state.pos;
                state.pos = start + 1;
                // Earlier we checked !silent, but this implementation does not need it
                token = state.push('sub_open', 'sub', 1);
                token.markup = '~';
                token = state.push('text', '', 0);
                token.content = content.replace(UNESCAPE_RE, '$1');
                token = state.push('sub_close', 'sub', -1);
                token.markup = '~';
                state.pos = state.posMax + 1;
                state.posMax = max;
                return true;
            }
            const md = markdownit({
                linkify: true, // 识别链接
                highlight: function(str, lang) { // markdown高亮
                    try {
                        return hljs.highlightAuto(str).value;
                    } catch (e) {}
                    return ""; // use external default escaping
                }
            });
            md.inline.ruler.after("emphasis", "sup", superscript);
            md.inline.ruler.after("emphasis", "sub", subscript);
            md.use(texmath, {
                engine: katex,
                delimiters: ["brackets", "dollars"]
            });
            md.renderer.rules.link_open = (tokens, idx, options, env, self) => {
                let aIndex = tokens[idx].attrIndex("target");
                if (tokens[idx + 1] && tokens[idx + 1].type === "image") tokens[idx].attrPush(["download", ""]);
                else if (aIndex < 0) tokens[idx].attrPush(["target", "_blank"]);
                else tokens[idx].attrs[aIndex][1] = "_blank";
                return self.renderToken(tokens, idx, options);
            };
            const codeUtils = {
                getCodeLang(str = "") {
                    const res = str.match(/ class="language-(.*?)"/);
                    return (res && res[1]) || "";
                },
                getFragment(str = "") {
                    return str ? `<span class="u-mdic-copy-code_lang" text="${str}"></span>` : "";
                },
            };
            const getCodeLangFragment = (oriStr = "") => {
                return codeUtils.getFragment(codeUtils.getCodeLang(oriStr));
            };
            const copyClickCode = (ele) => {
                const input = document.createElement("textarea");
                input.value = ele.parentElement.previousElementSibling.textContent;
                const nDom = ele.previousElementSibling;
                const nDelay = ele.dataset.mdicNotifyDelay;
                const cDom = nDom.previousElementSibling;
                document.body.appendChild(input);
                input.select();
                input.setSelectionRange(0, input.value.length);
                document.execCommand("copy");
                document.body.removeChild(input);
                if (nDom.style.display === "none") {
                    nDom.style.display = "block";
                    cDom && (cDom.style.display = "none");
                    setTimeout(() => {
                        nDom.style.display = "none";
                        cDom && (cDom.style.display = "block");
                    }, nDelay);
                }
            };
            const copyClickMd = (idx) => {
                const input = document.createElement("textarea");
                input.value = data[idx].content;
                document.body.appendChild(input);
                input.select();
                input.setSelectionRange(0, input.value.length);
                document.execCommand("copy");
                document.body.removeChild(input);
            }
            const enhanceCode = (render, options = {}) => (...args) => {
                /* args = [tokens, idx, options, env, slf] */
                const {
                    btnText = translations[locale]["copyCode"], // button text
                        successText = translations[locale]["copySuccess"], // copy-success text
                        successTextDelay = 2000, // successText show time [ms]
                        showCodeLanguage = true, // false | show code language
                } = options;
                const [tokens = {}, idx = 0] = args;
                const originResult = render.apply(this, args);
                const langFrag = showCodeLanguage ? getCodeLangFragment(originResult) : "";
                const tpls = [
                    '<div class="m-mdic-copy-wrapper">',
                    `${langFrag}`,
                    `<div class="u-mdic-copy-notify" style="display:none;" text="${successText}"></div>`,
                    `<button class="u-mdic-copy-btn j-mdic-copy-btn" text="${btnText}" data-mdic-notify-delay="${successTextDelay}" onclick="copyClickCode(this)"></button>`,
                    '</div>',
                ];
                return originResult.replace("</pre>", `${tpls.join("")}</pre>`);
            };
            md.renderer.rules.code_block = enhanceCode(md.renderer.rules.code_block);
            md.renderer.rules.fence = enhanceCode(md.renderer.rules.fence);
            md.renderer.rules.image = function(tokens, idx, options, env, self) {
                let token = tokens[idx];
                token.attrs[token.attrIndex("alt")][1] = self.renderInlineAsText(token.children, options, env);
                token.attrSet("onload", "scrollToBottomLoad(this);this.removeAttribute('onload');this.removeAttribute('onerror')");
                token.attrSet("onerror", "scrollToBottomLoad(this);this.removeAttribute('onload');this.removeAttribute('onerror')");
                token.attrPush(["decoding", "async"]);
                token.attrPush(["loading", "lazy"]);
                return self.renderToken(tokens, idx, options)
            }
            let currentVoiceIdx;
            let editingIdx;
            let originText;
            const resumeSend = () => {
                if (editingIdx !== void 0) {
                    chatlog.children[systemRole ? editingIdx - 1 : editingIdx].classList.remove("showEditReq");
                }
                sendBtnEle.children[0].textContent = translations[locale]["send"];
                inputAreaEle.value = originText;
                clearEle.title = translations[locale]["clearChat"];
                clearEle.classList.remove("closeConv");
                originText = void 0;
                editingIdx = void 0;
            }
            const mdOptionEvent = function(ev) {
                let id = ev.target.dataset.id;
                if (id) {
                    let parent = ev.target.parentElement;
                    let idxEle = parent.parentElement;
                    let idx = Array.prototype.indexOf.call(chatlog.children, this.parentElement);
                    if (id === "voiceBtn" || id === "speechMd" || id === "pauseMd" || id === "resumeMd") {
                        let classList = parent.dataset.id === "voiceBtn" ? parent.classList : ev.target.classList;
                        if (classList.contains("readyVoice")) {
                            if (chatlog.children[idx].dataset.loading !== "true") {
                                idx = systemRole ? idx + 1 : idx;
                                speechEvent(idx);
                            }
                        } else if (classList.contains("pauseVoice")) {
                            if (voiceIns) {
                                if (voiceIns instanceof Audio) voiceIns.pause();
                                else {
                                    if (supportSpe) speechSynthesis.pause();
                                    classList.remove("readyVoice");
                                    classList.remove("pauseVoice");
                                    classList.add("resumeVoice");
                                }
                            }
                        } else {
                            if (voiceIns) {
                                if (voiceIns instanceof Audio) voiceIns.play();
                                else {
                                    if (supportSpe) speechSynthesis.resume();
                                    classList.remove("readyVoice");
                                    classList.remove("resumeVoice");
                                    classList.add("pauseVoice");
                                }
                            }
                        }
                    } else if (id === "editMd") {
                        let reqEle = chatlog.children[idx];
                        idx = systemRole ? idx + 1 : idx;
                        if (editingIdx === idx) return;
                        if (editingIdx !== void 0) {
                            chatListEle.children[systemRole ? editingIdx - 1 : editingIdx].classList.remove("showEditReq");
                        }
                        reqEle.classList.add("showEditReq");
                        editingIdx = idx;
                        originText = inputAreaEle.value;
                        inputAreaEle.value = data[idx].content;
                        inputAreaEle.dispatchEvent(new Event("input"));
                        inputAreaEle.focus();
                        sendBtnEle.children[0].textContent = translations[locale]["update"];
                        clearEle.title = translations[locale]["cancel"];
                        clearEle.classList.add("closeConv");
                    } else if (id === "refreshMd") {
                        if (noLoading()) {
                            if (ev.target.classList.contains("refreshReq")) {
                                chatlog.children[idx].children[1].innerHTML = "<p class='cursorCls'><br /></p>";
                                chatlog.children[idx].dataset.loading = true;
                                idx = systemRole ? idx + 1 : idx;
                                data[idx].content = "";
                                if (idx === data.findIndex(item => {
                                        return item.role === "assistant"
                                    })) activeChatEle.children[1].children[1].textContent = "";
                                if (idx === currentVoiceIdx) endSpeak();
                                loadAction(true);
                                refreshIdx = idx;
                                streamGen();
                            } else {
                                chatlog.children[idx].dataset.loading = true;
                                idx = systemRole ? idx + 1 : idx;
                                progressData = data[idx].content;
                                loadAction(true);
                                refreshIdx = idx;
                                streamGen(true);
                            }
                        }
                    } else if (id === "copyMd") {
                        idx = systemRole ? idx + 1 : idx;
                        copyClickMd(idx);
                        notyf.success(translations[locale]["copySuccess"]);
                    } else if (id === "delMd") {
                        if (noLoading()) {
                            if (confirmAction(translations[locale]["delMsgTip"])) {
                                chatlog.removeChild(chatlog.children[idx]);
                                idx = systemRole ? idx + 1 : idx;
                                let firstIdx = data.findIndex(item => {
                                    return item.role === "assistant"
                                });
                                if (currentVoiceIdx !== void 0) {
                                    if (currentVoiceIdx === idx) {
                                        endSpeak()
                                    } else if (currentVoiceIdx > idx) {
                                        currentVoiceIdx--
                                    }
                                }
                                if (editingIdx !== void 0) {
                                    if (editingIdx === idx) {
                                        resumeSend()
                                    } else if (editingIdx > idx) {
                                        editingIdx--
                                    }
                                }
                                data.splice(idx, 1);
                                if (firstIdx === idx) updateChatPre();
                                updateChats();
                            }
                        }
                    } else if (id === "downAudioMd") {
                        if (chatlog.children[idx].dataset.loading !== "true") {
                            idx = systemRole ? idx + 1 : idx;
                            downloadAudio(idx);
                        }
                    }
                }
            }
            const formatMdEle = (ele, model) => {
                let avatar = document.createElement("div");
                avatar.className = "chatAvatar";
                if (ele.className === "response") avatar.classList.add((model && model.startsWith("gpt-4")) ? "gpt4Avatar" : "gpt3Avatar");
                avatar.innerHTML = ele.className === "request" ? `<img src="${userAvatar}" />` : `<svg width="22" height="22"><use xlink:href="#aiIcon"></use></svg>`;
                ele.appendChild(avatar);
                let realMd = document.createElement("div");
                realMd.className = ele.className === "request" ? "requestBody" : "markdown-body";
                ele.appendChild(realMd);
                let mdOption = document.createElement("div");
                mdOption.className = "mdOption";
                ele.appendChild(mdOption);
                let optionWidth = existVoice >= 2 ? 140 : 105;
                mdOption.innerHTML += `<div class="optionItems" style="width:${optionWidth}px;left:-${optionWidth - 10}px">` +
                    (ele.className === "request" ? `<div data-id="editMd" class="optionItem" title="${translations[locale]["edit"]}">
                <svg width="18" height="18"><use xlink:href="#chatEditIcon" /></svg>
                </div>` : `<div data-id="refreshMd" class="refreshReq optionItem" title="${translations[locale]["refresh"]}">
                <svg width="16" height="16" ><use xlink:href="#refreshIcon" /></svg>
                <svg width="16" height="16" ><use xlink:href="#halfRefIcon" /></svg>
                </div>`) +
                    `<div data-id="copyMd" class="optionItem" title="${translations[locale]["copy"]}">
                <svg width="20" height="20"><use xlink:href="#copyIcon" /></svg>
            </div>
            <div data-id="delMd" class="optionItem" title="${translations[locale]["del"]}">
                <svg width="20" height="20"><use xlink:href="#delIcon" /></svg>
            </div>` + (existVoice >= 2 ? `<div data-id="downAudioMd" class="optionItem" title="${translations[locale]["downAudio"]}">
                <svg width="20" height="20"><use xlink:href="#downAudioIcon" /></svg>
            </div>` : "") + `</div>`;
                if (existVoice) {
                    mdOption.innerHTML += `<div class="voiceCls readyVoice" data-id="voiceBtn">
                <svg width="20" height="20" role="img" data-id="speechMd"><title>${translations[locale]["speech"]}</title><use xlink:href="#readyVoiceIcon" /></svg>
                <svg width="20" height="20" role="img" data-id="pauseMd"><title>${translations[locale]["pause"]}</title><use xlink:href="#pauseVoiceIcon" /></svg>
                <svg width="20" height="20" role="img" data-id="resumeMd"><title>${translations[locale]["resume"]}</title><use xlink:href="#resumeVoiceIcon" /></svg>
                </div>`
                }
                mdOption.onclick = mdOptionEvent;
            }
            let allListEle = chatListEle.parentElement;
            let folderData = [];
            let chatsData = [];
            let chatIdxs = [];
            let searchIdxs = [];
            let activeChatIdx = 0;
            let activeChatEle;
            let operateChatIdx, operateFolderIdx;
            let dragLi, dragType, dragIdx;
            let mobileDragOut;
            const mobileDragStartEV = function(ev) {
                if (mobileDragOut !== void 0) {
                    clearTimeout(mobileDragOut);
                    mobileDragOut = void 0;
                }
                mobileDragOut = setTimeout(() => {
                    this.setAttribute("draggable", "true");
                    this.dispatchEvent(ev);
                }, 200);
            };
            if (isMobile) {
                let stopDragOut = () => {
                    if (mobileDragOut !== void 0) {
                        clearTimeout(mobileDragOut);
                        mobileDragOut = void 0;
                    }
                };
                let stopDrag = () => {
                    stopDragOut();
                    document.querySelectorAll("[draggable=true]").forEach(ele => {
                        ele.setAttribute("draggable", "false");
                    })
                };
                document.body.addEventListener("touchmove", stopDragOut);
                document.body.addEventListener("touchend", stopDrag);
                document.body.addEventListener("touchcancel", stopDrag);
            };
            const delDragIdx = () => {
                let chatIdx = chatIdxs.indexOf(dragIdx);
                if (chatIdx !== -1) {
                    chatIdxs.splice(chatIdx, 1);
                } else {
                    folderData.forEach((item, i) => {
                        let inIdx = item.idxs.indexOf(dragIdx);
                        if (inIdx !== -1) {
                            item.idxs.splice(inIdx, 1);
                            updateFolder(i);
                        }
                    })
                }
            }
            const updateFolder = (idx) => {
                let folderEle = folderListEle.children[idx];
                let childLen = folderData[idx].idxs.length;
                folderEle.children[0].children[1].children[1].textContent = childLen + translations[locale]["chats"];
                folderEle.classList.toggle("expandFolder", childLen);
            }
            folderListEle.ondragenter = chatListEle.ondragenter = function(ev) {
                ev.preventDefault();
                if (ev.target === dragLi) return;
                allListEle.querySelectorAll(".dragingChat").forEach(ele => {
                    ele.classList.remove("dragingChat");
                })
                if (dragType === "chat") {
                    if (this === chatListEle) {
                        this.classList.add("dragingChat");
                        let dragindex = Array.prototype.indexOf.call(chatListEle.children, dragLi);
                        let targetindex = Array.prototype.indexOf.call(chatListEle.children, ev.target);
                        delDragIdx();
                        if (targetindex !== -1) {
                            chatIdxs.splice(targetindex, 0, dragIdx);
                            if (dragindex === -1 || dragindex >= targetindex) {
                                chatListEle.insertBefore(dragLi, ev.target);
                            } else {
                                chatListEle.insertBefore(dragLi, ev.target.nextElementSibling);
                            }
                        } else {
                            chatIdxs.push(dragIdx);
                            chatListEle.appendChild(dragLi);
                        }
                    } else if (this === folderListEle) {
                        let folderIdx;
                        if (ev.target.classList.contains("headLi")) {
                            ev.target.parentElement.classList.add("dragingChat");
                            ev.target.nextElementSibling.appendChild(dragLi);
                            delDragIdx();
                            folderIdx = Array.prototype.indexOf.call(folderListEle.children, ev.target.parentElement);
                            folderData[folderIdx].idxs.push(dragIdx);
                            updateFolder(folderIdx);
                        } else if (ev.target.classList.contains("chatLi")) {
                            ev.target.parentElement.parentElement.classList.add("dragingChat");
                            let parent = ev.target.parentElement;
                            delDragIdx();
                            folderIdx = Array.prototype.indexOf.call(folderListEle.children, parent.parentElement);
                            let dragindex = Array.prototype.indexOf.call(parent.children, dragLi);
                            let targetindex = Array.prototype.indexOf.call(parent.children, ev.target);
                            if (dragindex !== -1) {
                                folderData[folderIdx].idxs.splice(targetindex, 0, dragIdx);
                                if (dragindex < targetindex) {
                                    parent.insertBefore(dragLi, ev.target.nextElementSibling);
                                } else {
                                    parent.insertBefore(dragLi, ev.target);
                                }
                            } else {
                                folderData[folderIdx].idxs.push(dragIdx);
                                parent.appendChild(dragLi);
                            }
                            updateFolder(folderIdx);
                        }
                    }
                    updateChatIdxs();
                } else if (dragType === "folder") {
                    if (this === folderListEle) {
                        let dragindex = Array.prototype.indexOf.call(folderListEle.children, dragLi);
                        let folderIdx = Array.prototype.findIndex.call(folderListEle.children, (item) => {
                            return item.contains(ev.target);
                        })
                        folderListEle.children[folderIdx].classList.remove("expandFolder");
                        let folderEle = folderListEle.children[folderIdx];
                        let data = folderData.splice(dragindex, 1)[0];
                        folderData.splice(folderIdx, 0, data);
                        if (dragindex === -1 || dragindex >= folderIdx) {
                            folderListEle.insertBefore(dragLi, folderEle);
                        } else {
                            folderListEle.insertBefore(dragLi, folderEle.nextElementSibling);
                        }
                        updateChatIdxs();
                    }
                }
            }
            folderListEle.ondragover = chatListEle.ondragover = (ev) => {
                ev.preventDefault();
            }
            folderListEle.ondragend = chatListEle.ondragend = (ev) => {
                document.getElementsByClassName("dragingLi")[0].classList.remove("dragingLi");
                allListEle.querySelectorAll(".dragingChat").forEach(ele => {
                    ele.classList.remove("dragingChat");
                })
                dragType = dragIdx = dragLi = void 0;
            }
            const chatDragStartEv = function(ev) {
                ev.stopPropagation();
                dragLi = this;
                dragLi.classList.add("dragingLi");
                dragType = "chat";
                if (chatListEle.contains(this)) {
                    let idx = Array.prototype.indexOf.call(chatListEle.children, this);
                    dragIdx = chatIdxs[idx];
                } else if (folderListEle.contains(this)) {
                    let folderIdx = Array.prototype.indexOf.call(folderListEle.children, this.parentElement.parentElement);
                    let inFolderIdx = Array.prototype.indexOf.call(this.parentElement.children, this);
                    dragIdx = folderData[folderIdx].idxs[inFolderIdx];
                }
            }
            const extraFolderActive = (folderIdx) => {
                let folderNewIdx = -1;
                for (let i = folderIdx - 1; i >= 0; i--) {
                    if (folderData[i].idxs.length) {
                        folderNewIdx = i;
                    }
                }
                if (folderNewIdx === -1) {
                    for (let i = folderIdx + 1; i < folderData.length; i++) {
                        if (folderData[i].idxs.length) folderNewIdx = i;
                    }
                }
                if (folderNewIdx !== -1) {
                    activeChatIdx = folderData[folderNewIdx].idxs[0];
                } else if (chatIdxs.length) {
                    activeChatIdx = chatIdxs[0];
                } else {
                    activeChatIdx = -1;
                }
            }
            const delFolder = (folderIdx, ele) => {
                if (confirmAction(translations[locale]["delFolderTip"])) {
                    let delData = folderData[folderIdx];
                    let idxs = delData.idxs.sort();
                    ele.parentElement.remove();
                    if (idxs.indexOf(activeChatIdx) !== -1) {
                        endAll();
                        extraFolderActive(folderIdx);
                    }
                    folderData.splice(folderIdx, 1);
                    for (let i = idxs.length - 1; i >= 0; i--) {
                        chatsData.splice(idxs[i], 1);
                    }
                    folderData.forEach(item => {
                        if (item.idxs.length) {
                            item.idxs.forEach((i, ix) => {
                                let len = idxs.filter(j => {
                                    return i > j
                                }).length;
                                if (len) {
                                    item.idxs[ix] = i - len;
                                }
                            })
                        }
                    })
                    chatIdxs.forEach((item, ix) => {
                        let len = idxs.filter(j => {
                            return item > j
                        }).length;
                        if (len) chatIdxs[ix] = item - len;
                    })
                    let len = idxs.filter(j => {
                        return activeChatIdx > j
                    }).length;
                    if (len) activeChatIdx -= len;
                    if (activeChatIdx === -1) {
                        addNewChat();
                        activeChatIdx = 0;
                        chatEleAdd(activeChatIdx);
                    }
                    updateChats();
                    activeChat();
                }
            }
            const folderAddChat = (folderIdx, headEle) => {
                endAll();
                let chat = {
                    name: translations[locale]["newChatName"],
                    data: []
                };
                chatsData.push(chat);
                activeChatIdx = chatsData.length - 1;
                folderData[folderIdx].idxs.push(activeChatIdx);
                let ele = chatEleAdd(activeChatIdx, false)
                headEle.nextElementSibling.appendChild(ele);
                updateFolder(folderIdx);
                updateChats();
                activeChat(ele);
            }
            const folderEleEvent = function(ev) {
                ev.preventDefault();
                ev.stopPropagation();
                let parent = this.parentElement;
                let idx = Array.prototype.indexOf.call(folderListEle.children, parent);
                if (ev.target.className === "headLi") {
                    let isExpanded = parent.classList.toggle("expandFolder");
                    if (folderData[idx].idxs.indexOf(activeChatIdx) !== -1) {
                        parent.classList.toggle("activeFolder", !isExpanded);
                    }
                } else if (ev.target.dataset.type === "folderAddChat") {
                    folderAddChat(idx, this);
                } else if (ev.target.dataset.type === "folderEdit") {
                    toEditName(idx, this, 0);
                } else if (ev.target.dataset.type === "folderDel") {
                    delFolder(idx, this);
                }
            }
            const folderDragStartEv = function(ev) {
                dragLi = this;
                dragLi.classList.add("dragingLi");
                dragType = "folder";
                dragIdx = Array.prototype.indexOf.call(folderListEle.children, this);
            }
            const folderEleAdd = (idx, push = true) => {
                let folder = folderData[idx];
                let folderEle = document.createElement("div");
                folderEle.className = "folderLi";
                if (!isMobile) folderEle.setAttribute("draggable", "true");
                else folderEle.ontouchstart = mobileDragStartEV;
                let headEle = document.createElement("div");
                headEle.className = "headLi";
                headEle.innerHTML = `<svg width="24" height="24"><use xlink:href="#expandFolderIcon" /></svg>
                <div class="folderInfo">
                    <div class="folderName"></div>
                    <div class="folderNum"></div>
                </div>
                <div class="folderOption">
                    <svg data-type="folderAddChat" width="24" height="24" role="img"><title>${translations[locale]["newChat"]}</title><use xlink:href="#addIcon" /></svg>
                    <svg data-type="folderEdit" width="24" height="24" role="img"><title>${translations[locale]["edit"]}</title><use xlink:href="#chatEditIcon" /></svg>
                    <svg data-type="folderDel" width="24" height="24" role="img"><title>${translations[locale]["del"]}</title><use xlink:href="#delIcon" /></svg>
                </div>`
                headEle.children[1].children[0].textContent = folder.name;
                headEle.children[1].children[1].textContent = folder.idxs.length + translations[locale]["chats"];
                folderEle.appendChild(headEle);
                folderEle.ondragstart = folderDragStartEv;
                headEle.onclick = folderEleEvent;
                let chatsEle = document.createElement("div");
                chatsEle.className = "chatsInFolder";
                for (let i = 0; i < folder.idxs.length; i++) {
                    chatsEle.appendChild(chatEleAdd(folder.idxs[i], false));
                }
                folderEle.appendChild(chatsEle);
                if (push) {
                    folderListEle.appendChild(folderEle)
                } else {
                    folderListEle.insertBefore(folderEle, folderListEle.firstChild)
                }
            }
            document.getElementById("newFolder").onclick = function() {
                folderData.unshift({
                    name: translations[locale]["newFolderName"],
                    idxs: []
                });
                folderEleAdd(0, false);
                updateChatIdxs();
                folderListEle.parentElement.scrollTop = 0;
            };
            const initChatEle = (index, chatEle) => {
                chatEle.children[1].children[0].textContent = chatsData[index].name;
                let chatPreview = "";
                if (chatsData[index].data && chatsData[index].data.length) {
                    let first = chatsData[index].data.find(item => {
                        return item.role === "assistant"
                    });
                    if (first) {
                        chatPreview = first.content.slice(0, 30)
                    }
                }
                chatEle.children[1].children[1].textContent = chatPreview;
            };
            const chatEleAdd = (idx, appendChat = true) => {
                let chat = chatsData[idx];
                let chatEle = document.createElement("div");
                chatEle.className = "chatLi";
                if (!isMobile) chatEle.setAttribute("draggable", "true");
                else chatEle.ontouchstart = mobileDragStartEV;
                chatEle.ondragstart = chatDragStartEv;
                chatEle.innerHTML = `<svg width="24" height="24"><use xlink:href="#chatIcon" /></svg>
                <div class="chatInfo">
                    <div class="chatName"></div>
                    <div class="chatPre"></div>
                </div>
                <div class="chatOption"><svg data-type="chatEdit" width="24" height="24" role="img"><title>${translations[locale]["edit"]}</title><use xlink:href="#chatEditIcon" /></svg>
                <svg data-type="chatDel" width="24" height="24" role="img"><title>${translations[locale]["del"]}</title><use xlink:href="#delIcon" /></svg></div>`
                if (appendChat) chatListEle.appendChild(chatEle);
                initChatEle(idx, chatEle);
                chatEle.onclick = chatEleEvent;
                return chatEle;
            };
            const addNewChat = () => {
                let chat = {
                    name: translations[locale]["newChatName"],
                    data: []
                };
                if (presetRoleData.default) chat.data.unshift({
                    role: "system",
                    content: presetRoleData.default
                });
                preEle.selectedIndex = 0;
                chatsData.push(chat);
                chatIdxs.push(chatsData.length - 1);
                updateChats();
            };
            const delChat = (idx, ele, folderIdx, inFolderIdx) => {
                if (confirmAction(translations[locale]["delChatTip"])) {
                    if (idx === activeChatIdx) endAll();
                    if (folderIdx !== void 0) {
                        let folder = folderData[folderIdx];
                        folder.idxs.splice(inFolderIdx, 1);
                        updateFolder(folderIdx);
                        if (idx === activeChatIdx) {
                            if (inFolderIdx - 1 >= 0) {
                                activeChatIdx = folder.idxs[inFolderIdx - 1];
                            } else if (folder.idxs.length) {
                                activeChatIdx = folder.idxs[0];
                            } else {
                                extraFolderActive(folderIdx);
                            }
                        }
                    } else {
                        let chatIdx = chatIdxs.indexOf(idx);
                        chatIdxs.splice(chatIdx, 1);
                        if (idx === activeChatIdx) {
                            if (chatIdx - 1 >= 0) {
                                activeChatIdx = chatIdxs[chatIdx - 1];
                            } else if (chatIdxs.length) {
                                activeChatIdx = chatIdxs[0];
                            } else {
                                let folderNewIdx = -1;
                                for (let i = folderData.length - 1; i >= 0; i--) {
                                    if (folderData[i].idxs.length) folderNewIdx = i;
                                }
                                if (folderNewIdx !== -1) {
                                    activeChatIdx = folderData[folderNewIdx].idxs[0];
                                } else {
                                    activeChatIdx = -1;
                                }
                            }
                        }
                    }
                    if (activeChatIdx > idx) activeChatIdx--;
                    chatsData.splice(idx, 1);
                    ele.remove();
                    folderData.forEach(item => {
                        if (item.idxs.length) {
                            item.idxs.forEach((i, ix) => {
                                if (i > idx) item.idxs[ix] = i - 1;
                            })
                        }
                    })
                    chatIdxs.forEach((item, ix) => {
                        if (item > idx) chatIdxs[ix] = item - 1;
                    })
                    if (activeChatIdx === -1) {
                        addNewChat();
                        activeChatIdx = 0;
                        chatEleAdd(activeChatIdx);
                    }
                    updateChats();
                    activeChat();
                }
            };
            const endEditEvent = (ev) => {
                if (!document.getElementById("activeChatEdit").contains(ev.target)) {
                    endEditChat();
                }
            };
            const preventDrag = (ev) => {
                ev.preventDefault();
                ev.stopPropagation();
            }
            const endEditChat = () => {
                if (operateChatIdx !== void 0) {
                    let ele = getChatEle(operateChatIdx);
                    chatsData[operateChatIdx].name = ele.children[1].children[0].textContent = document.getElementById("activeChatEdit").value;
                    ele.lastElementChild.remove();
                } else if (operateFolderIdx !== void 0) {
                    let ele = folderListEle.children[operateFolderIdx].children[0];
                    folderData[operateFolderIdx].name = ele.children[1].children[0].textContent = document.getElementById("activeChatEdit").value;
                    ele.lastElementChild.remove();
                }
                updateChats();
                operateChatIdx = operateFolderIdx = void 0;
                document.body.removeEventListener("mousedown", endEditEvent, true);
            }
            const toEditName = (idx, ele, type) => {
                let inputEle = document.createElement("input");
                inputEle.id = "activeChatEdit";
                inputEle.setAttribute("draggable", "true");
                inputEle.ondragstart = preventDrag;
                ele.appendChild(inputEle);
                if (type) {
                    inputEle.value = chatsData[idx].name;
                    operateChatIdx = idx;
                } else {
                    inputEle.value = folderData[idx].name;
                    operateFolderIdx = idx;
                }
                inputEle.setSelectionRange(0, 0);
                inputEle.focus();
                inputEle.onkeydown = (e) => {
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        endEditChat();
                    }
                };
                document.body.addEventListener("mousedown", endEditEvent, true);
                return inputEle;
            };
            const chatEleEvent = function(ev) {
                ev.preventDefault();
                ev.stopPropagation();
                let idx, folderIdx, inFolderIdx;
                if (chatListEle.contains(this)) {
                    idx = Array.prototype.indexOf.call(chatListEle.children, this);
                    idx = chatIdxs[idx];
                } else if (folderListEle.contains(this)) {
                    folderIdx = Array.prototype.indexOf.call(folderListEle.children, this.parentElement.parentElement);
                    inFolderIdx = Array.prototype.indexOf.call(this.parentElement.children, this);
                    idx = folderData[folderIdx].idxs[inFolderIdx];
                }
                if (ev.target.classList.contains("chatLi")) {
                    if (searchChatEle.value || activeChatIdx !== idx) {
                        endAll();
                        activeChatIdx = idx;
                        activeChat(this);
                    }
                    if (window.innerWidth <= 800) {
                        document.body.classList.remove("show-nav");
                    }
                } else if (ev.target.dataset.type === "chatEdit") {
                    toEditName(idx, this, 1);
                } else if (ev.target.dataset.type === "chatDel") {
                    delChat(idx, this, folderIdx, inFolderIdx);
                }
            };
            const updateChats = () => {
                localStorage.setItem("chats", JSON.stringify(chatsData));
                updateChatIdxs();
            };
            const updateChatIdxs = () => {
                localStorage.setItem("chatIdxs", JSON.stringify(chatIdxs));
                localStorage.setItem("folders", JSON.stringify(folderData));
            }
            const createConvEle = (className, append = true, model) => {
                let div = document.createElement("div");
                div.className = className;
                formatMdEle(div, model);
                if (append) chatlog.appendChild(div);
                return div;
            }
            const getChatEle = (idx) => {
                let chatIdx = chatIdxs.indexOf(idx);
                if (chatIdx !== -1) {
                    return chatListEle.children[chatIdx];
                } else {
                    let inFolderIdx;
                    let folderIdx = folderData.findIndex(item => {
                        inFolderIdx = item.idxs.indexOf(idx);
                        return inFolderIdx !== -1;
                    })
                    if (folderIdx !== -1) {
                        return folderListEle.children[folderIdx].children[1].children[inFolderIdx];
                    }
                }
            }
            const activeChat = (ele) => {
                data = chatsData[activeChatIdx]["data"];
                allListEle.querySelectorAll(".activeChatLi").forEach(ele => {
                    ele.classList.remove("activeChatLi");
                })
                allListEle.querySelectorAll(".activeFolder").forEach(ele => {
                    ele.classList.remove("activeFolder")
                })
                if (!ele) ele = getChatEle(activeChatIdx);
                ele.classList.add("activeChatLi");
                activeChatEle = ele;
                if (chatIdxs.indexOf(activeChatIdx) === -1) {
                    if (!ele.parentElement.parentElement.classList.contains("expandFolder")) {
                        ele.parentElement.parentElement.classList.add("activeFolder");
                    }
                }
                if (data[0] && data[0].role === "system") {
                    systemRole = data[0].content;
                    systemEle.value = systemRole;
                } else {
                    systemRole = void 0;
                    systemEle.value = "";
                }
                chatlog.innerHTML = "";
                if (systemRole ? data.length - 1 : data.length) {
                    let firstIdx = systemRole ? 1 : 0;
                    for (let i = firstIdx; i < data.length; i++) {
                        if (data[i].role === "user") {
                            createConvEle("request").children[1].textContent = data[i].content;
                        } else {
                            createConvEle("response", true, data[i].model).children[1].innerHTML = md.render(data[i].content) || "<br />";
                        }
                    }
                }
                let top = ele.offsetTop + ele.offsetHeight - allListEle.clientHeight;
                if (allListEle.scrollTop < top) allListEle.scrollTop = top;
                localStorage.setItem("activeChatIdx", activeChatIdx);
                if (searchIdxs[activeChatIdx] !== void 0) {
                    let dataIdx = searchIdxs[activeChatIdx];
                    if (dataIdx !== -1) {
                        let currChatEle = chatlog.children[systemRole ? dataIdx - 1 : dataIdx];
                        let childs = currChatEle.children[1].getElementsByTagName("*");
                        if (childs.length) {
                            for (let i = childs.length - 1; i >= 0; i--) {
                                if (childs[i].textContent && childs[i].textContent.indexOf(searchChatEle.value) !== -1) {
                                    let offTop = findOffsetTop(childs[i], messagesEle);
                                    messagesEle.scrollTop = offTop + childs[i].offsetHeight - messagesEle.clientHeight * 0.15;
                                    break;
                                }
                            }
                        } else messagesEle.scrollTop = currChatEle.offsetTop;
                    } else messagesEle.scrollTop = 0;
                }
            };
            newChatEle.onclick = () => {
                endAll();
                addNewChat();
                activeChatIdx = chatsData.length - 1;
                chatEleAdd(activeChatIdx);
                activeChat(chatListEle.lastElementChild);
            };
            const initChats = () => {
                let localChats = localStorage.getItem("chats");
                let localFolders = localStorage.getItem("folders");
                let localChatIdxs = localStorage.getItem("chatIdxs")
                let localChatIdx = localStorage.getItem("activeChatIdx");
                activeChatIdx = (localChatIdx && parseInt(localChatIdx)) || 0;
                if (localChats) {
                    if (isCompressedChats) localChats = new TextDecoder().decode(inflateSync(stringToUint(localChats)));
                    chatsData = JSON.parse(localChats);
                    let folderIdxs = [];
                    if (localFolders) {
                        folderData = JSON.parse(localFolders);
                        for (let i = 0; i < folderData.length; i++) {
                            folderEleAdd(i);
                            folderIdxs.push(...folderData[i].idxs);
                        }
                    }
                    if (localChatIdxs) {
                        chatIdxs = JSON.parse(localChatIdxs);
                        for (let i = 0; i < chatIdxs.length; i++) {
                            chatEleAdd(chatIdxs[i]);
                        }
                    } else {
                        for (let i = 0; i < chatsData.length; i++) {
                            if (folderIdxs.indexOf(i) === -1) {
                                chatIdxs.push(i);
                                chatEleAdd(i);
                            }
                        }
                        updateChatIdxs();
                    }
                } else {
                    addNewChat();
                    chatEleAdd(activeChatIdx);
                }
            };
            const initExpanded = () => {
                let folderIdx = folderData.findIndex(item => {
                    return item.idxs.indexOf(activeChatIdx) !== -1;
                })
                if (folderIdx !== -1) {
                    folderListEle.children[folderIdx].classList.add("expandFolder");
                }
            }
            initChats();
            initExpanded();
            activeChat();
            document.getElementById("clearSearch").onclick = () => {
                searchChatEle.value = "";
                searchChatEle.dispatchEvent(new Event("input"));
                searchChatEle.focus();
            }
            const toSearchChats = () => {
                searchIdxs.length = 0;
                for (let i = 0; i < chatsData.length; i++) {
                    let chatEle = getChatEle(i);
                    chatEle.style.display = null;
                    let flags = isCaseSearch ? "" : "i";
                    let pattern = escapeRegexExp(searchChatEle.value);
                    let regex = new RegExp(pattern, flags);
                    let nameData = chatsData[i].name.match(regex);
                    let nameIdx = nameData ? nameData.index : -1;
                    let matchContent;
                    let dataIdx = chatsData[i].data.findIndex(item => {
                        return item.role !== "system" && (matchContent = item.content.match(regex))
                    })
                    if (nameIdx !== -1 || dataIdx !== -1) {
                        let ele = chatEle.children[1];
                        if (dataIdx !== -1) {
                            let data = chatsData[i].data[dataIdx];
                            let idx = matchContent.index;
                            let endIdx = idx + matchContent[0].length;
                            ele.children[1].textContent = (idx > 8 ? "..." : "") + data.content.slice(idx > 8 ? idx - 5 : 0, idx);
                            ele.children[1].appendChild(document.createElement("span"));
                            ele.children[1].lastChild.textContent = data.content.slice(idx, endIdx);
                            ele.children[1].appendChild(document.createTextNode(data.content.slice(endIdx)))
                        } else {
                            initChatEle(i, chatEle);
                        }
                        if (nameIdx !== -1) {
                            let endIdx = nameIdx + nameData[0].length;
                            ele.children[0].textContent = (nameIdx > 5 ? "..." : "") + chatsData[i].name.slice(nameIdx > 5 ? nameIdx - 3 : 0, nameIdx);
                            ele.children[0].appendChild(document.createElement("span"));
                            ele.children[0].lastChild.textContent = chatsData[i].name.slice(nameIdx, endIdx);
                            ele.children[0].appendChild(document.createTextNode(chatsData[i].name.slice(endIdx)))
                        } else {
                            ele.children[0].textContent = chatsData[i].name;
                        }
                        searchIdxs[i] = dataIdx;
                    } else {
                        chatEle.style.display = "none";
                        initChatEle(i, chatEle);
                    }
                }
                for (let i = 0; i < folderListEle.children.length; i++) {
                    let folderChatEle = folderListEle.children[i].children[1];
                    if (!folderChatEle.children.length || Array.prototype.filter.call(folderChatEle.children, (ele) => {
                            return ele.style.display !== "none"
                        }).length === 0) {
                        folderListEle.children[i].style.display = "none";
                    }
                }
            }
            searchChatEle.oninput = (ev) => {
                if (searchChatEle.value.length) {
                    toSearchChats();
                } else {
                    searchIdxs.length = 0;
                    for (let i = 0; i < chatsData.length; i++) {
                        let chatEle = getChatEle(i);
                        chatEle.style.display = null;
                        initChatEle(i, chatEle);
                    }
                    for (let i = 0; i < folderListEle.children.length; i++) {
                        folderListEle.children[i].style.display = null;
                    }
                }
            };
            document.getElementById("resetHotKey").onclick = () => {
                localStorage.removeItem("hotKeys");
                initHotKey();
                notyf.success(translations[locale]["resetSetSuccTip"]);
            };
            const blobToText = (blob) => {
                return new Promise((res, rej) => {
                    let reader = new FileReader();
                    reader.readAsText(blob);
                    reader.onload = () => {
                        res(reader.result);
                    }
                    reader.onerror = (error) => {
                        rej(error);
                    }
                })
            };
            document.getElementById("exportChat").onclick = () => {
                if (loading) stopLoading();
                let data = {
                    chatsData: chatsData,
                    folderData: folderData,
                    chatIdxs: chatIdxs
                }
                let blob = new Blob([JSON.stringify(data, null, 2)], {
                    type: "application/json"
                });
                let date = new Date();
                let fileName = "chats-" + date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + ".json";
                downBlob(blob, fileName);
                notyf.success(translations[locale]["exportSuccTip"]);
            };
            document.getElementById("importChatInput").onchange = function() {
                let file = this.files[0];
                blobToText(file).then(text => {
                    try {
                        let json = JSON.parse(text);
                        let checked = json.chatsData && json.folderData && json.chatIdxs && json.chatsData.every(item => {
                            return item.name !== void 0 && item.data !== void 0;
                        });
                        if (checked) {
                            let preFolder = folderData.length;
                            let preLen = chatsData.length;
                            if (json.chatsData) {
                                chatsData = chatsData.concat(json.chatsData);
                            }
                            if (json.folderData) {
                                for (let i = 0; i < json.folderData.length; i++) {
                                    json.folderData[i].idxs = json.folderData[i].idxs.map(item => {
                                        return item + preLen;
                                    })
                                    folderData.push(json.folderData[i]);
                                    folderEleAdd(i + preFolder);
                                }
                            }
                            if (json.chatIdxs) {
                                for (let i = 0; i < json.chatIdxs.length; i++) {
                                    let newIdx = json.chatIdxs[i] + preLen;
                                    chatIdxs.push(newIdx)
                                    chatEleAdd(newIdx);
                                }
                            }
                            updateChats();
                            checkStorage();
                            notyf.success(translations[locale]["importSuccTip"]);
                        } else {
                            throw new Error("fmt error");
                        }
                    } catch (e) {
                        notyf.error(translations[locale]["importFailTip"]);
                    }
                    this.value = "";
                })
            };
            clearChatSet.onclick = clearChat.onclick = () => {
                if (confirmAction(translations[locale]["clearAllTip"])) {
                    chatsData.length = 0;
                    chatIdxs.length = 0;
                    folderData.length = 0;
                    folderListEle.innerHTML = "";
                    chatListEle.innerHTML = "";
                    endAll();
                    addNewChat();
                    activeChatIdx = 0;
                    chatEleAdd(activeChatIdx);
                    localStorage.removeItem("compressedChats");
                    isCompressedChats = false;
                    updateChats();
                    checkStorage();
                    activeChat(chatListEle.firstElementChild);
                    notyf.success(translations[locale]["clearChatSuccTip"]);
                }
            };
            let localSetKeys = ['modelVersion', 'APISelect', 'APIHost', 'APIKey', 'hotKeys', 'userAvatar', 'system', 'temp', 'top_p', 'convWidth0', 'convWidth1', 'textSpeed', 'contLen', 'enableLongReply', 'existVoice', 'voiceTestText', 'azureRegion', 'azureKey', 'enableContVoice', 'enableAutoVoice', 'voiceRecLang', 'autoVoiceSendWord', 'autoVoiceStopWord', 'autoVoiceSendOut', 'keepListenMic', 'fullWindow', 'themeMode', 'autoThemeMode', 'customDarkTime', 'UILang', 'pinNav', 'voice0', 'voicePitch0', 'voiceVolume0', 'voiceRate0', 'azureRole0', 'azureStyle0', 'voice1', 'voicePitch1', 'voiceVolume1', 'voiceRate1', 'azureRole1', 'azureStyle1', 'searchFlag'];
            document.getElementById("exportSet").onclick = () => {
                let data = {}
                for (let i = 0; i < localSetKeys.length; i++) {
                    let key = localSetKeys[i];
                    let val = localStorage.getItem(key);
                    if (val != void 0) data[key] = val;
                }
                let blob = new Blob([JSON.stringify(data, null, 2)], {
                    type: "application/json"
                });
                let date = new Date();
                let fileName = "settings-" + date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + ".json";
                downBlob(blob, fileName);
                notyf.success(translations[locale]["exportSuccTip"]);
            };
            document.getElementById("importSetInput").onchange = function() {
                let file = this.files[0];
                blobToText(file).then(text => {
                    try {
                        let json = JSON.parse(text);
                        let keys = Object.keys(json);
                        for (let i = 0; i < localSetKeys.length; i++) {
                            let key = localSetKeys[i];
                            let val = json[key];
                            if (val !== void 0) localStorage.setItem(key, val);
                            else localStorage.removeItem(key);
                        }
                        initSetting();
                        initVoiceVal();
                        speechServiceEle.dispatchEvent(new Event("change"));
                        initRecSetting();
                        initHotKey();
                        initLang();
                        checkStorage();
                        notyf.success(translations[locale]["importSuccTip"]);
                    } catch (e) {
                        notyf.error(translations[locale]["importFailTip"]);
                    }
                    this.value = "";
                })
            };
            document.getElementById("resetSet").onclick = () => {
                if (confirmAction(translations[locale]["resetSetTip"])) {
                    endAll();
                    if (existVoice === 3) localStorage.removeItem(azureRegion + "voiceData");
                    let data = {};
                    for (let i = 0; i < localSetKeys.length; i++) {
                        let key = localSetKeys[i];
                        let val = localStorage.removeItem(key);
                    }
                    initSetting();
                    initVoiceVal();
                    speechServiceEle.dispatchEvent(new Event("change"));
                    initRecSetting();
                    initHotKey();
                    initLang();
                    checkStorage();
                    notyf.success(translations[locale]["resetSetSuccTip"]);
                }
            }
            const endAll = () => {
                endSpeak();
                if (editingIdx !== void 0) resumeSend();
                if (loading) stopLoading();
            };
            const processIdx = (plus) => {
                if (currentVoiceIdx !== void 0) currentVoiceIdx += plus;
                if (editingIdx !== void 0) editingIdx += plus;
            }
            const hotKeyVals = {};
            const ctrlHotKeyEv = (ev) => {
                if (ev.ctrlKey || ev.metaKey) {
                    switch (ev.key.toLowerCase()) {
                        case hotKeyVals["Nav"]:
                            ev.preventDefault();
                            toggleNavEv();
                            return false;
                        case hotKeyVals["Search"]:
                            ev.preventDefault();
                            searchChatEle.focus();
                            return false;
                        case hotKeyVals["Input"]:
                            ev.preventDefault();
                            inputAreaEle.focus();
                            return false;
                        case hotKeyVals["NewChat"]:
                            ev.preventDefault();
                            newChatEle.dispatchEvent(new MouseEvent("click"));
                            return false;
                        case hotKeyVals["ClearChat"]:
                            ev.preventDefault();
                            clearEle.dispatchEvent(new MouseEvent("click"));
                            return false;
                        case hotKeyVals["VoiceRec"]:
                            if (supportRec) {
                                ev.preventDefault();
                                toggleRecEv();
                            }
                            return false;
                        case hotKeyVals["VoiceSpeak"]:
                            ev.preventDefault();
                            speechEvent(systemRole ? 1 : 0);
                            return false;
                    }
                }
            }
            const ctrlAltHotKeyEv = (ev) => {
                if ((ev.ctrlKey || ev.metaKey) && ev.altKey) {
                    switch (ev.key.toLowerCase()) {
                        case hotKeyVals["Window"]:
                            ev.preventDefault();
                            toggleFull.dispatchEvent(new Event("click"));
                            return false;
                        case hotKeyVals["Theme"]:
                            ev.preventDefault();
                            lightEle.dispatchEvent(new Event("click"));
                            return false;
                        case hotKeyVals["Lang"]:
                            ev.preventDefault();
                            let idx = localeList.indexOf(locale) + 1;
                            if (idx === localeList.length) idx = 0;
                            locale = localeList[idx];
                            setLang();
                            changeLocale();
                            return false;
                    }
                }
            }
            const listKey = ['Nav', 'Search', 'Input', 'NewChat', 'ClearChat', 'VoiceRec', 'VoiceSpeak', 'Window', 'Theme', 'Lang'];
            const ctrlKeyIdx = 7;
            const defKeyVal = ['b', 'k', 'i', 'e', 'r', 'q', 's', 'u', 't', 'l'];
            const initHotKey = () => {
                let localKeysObj = {};
                let localKeys = localStorage.getItem("hotKeys");
                if (localKeys) {
                    try {
                        localKeysObj = JSON.parse(localKeys);
                    } catch (e) {}
                }
                let pre1 = isApple ? "⌘ + " : "Ctrl + ";
                let pre2 = isApple ? "⌘ + ⌥ + " : "Ctrl + Alt + ";
                for (let i = 0; i < listKey.length; i++) {
                    let key = listKey[i];
                    if (key === "VoiceRec" && !supportRec) continue;
                    let ele = window["hotKey" + key];
                    for (let j = 0; j < 26; j++) {
                        // top-level hotkey, can't overwrite
                        if (i < ctrlKeyIdx && (j === 13 || j === 19 || j === 22)) continue;
                        let val = String.fromCharCode(j + 97);
                        ele.options.add(new Option((i < ctrlKeyIdx ? pre1 : pre2) + val.toUpperCase(), val));
                    }
                    hotKeyVals[key] = ele.value = localKeysObj[key] || defKeyVal[i];
                    ele.onchange = () => {
                        if (hotKeyVals[key] === ele.value) return;
                        let exist = listKey.find((item, idx) => {
                            return (i < ctrlKeyIdx ? idx < ctrlKeyIdx : idx >= ctrlKeyIdx) && hotKeyVals[item] === ele.value;
                        })
                        if (exist) {
                            ele.value = hotKeyVals[key];
                            notyf.error(translations[locale]["hotkeyConflict"])
                            return;
                        }
                        hotKeyVals[key] = ele.value;
                        localStorage.setItem("hotKeys", JSON.stringify(hotKeyVals));
                    }
                }
            };
            initHotKey();
            document.addEventListener("keydown", ctrlHotKeyEv);
            document.addEventListener("keydown", ctrlAltHotKeyEv);
            const initSetting = () => {
                const modelEle = document.getElementById("preSetModel");
                let localModel = localStorage.getItem("modelVersion");
                modelVersion = modelEle.value = localModel || "gpt-3.5-turbo";
                modelEle.onchange = () => {
                    modelVersion = modelEle.value;
                    localStorage.setItem("modelVersion", modelVersion);
                }
                modelEle.dispatchEvent(new Event("change"));
                const apiHostEle = document.getElementById("apiHostInput");
                const apiSelectEle = document.getElementById("apiSelect");
                let localApiSelect = localStorage.getItem("APISelect");
                if (localApiSelect) {
                    try {
                        apiSelects = JSON.parse(localApiSelect);
                    } catch (e) {
                        apiSelects.length = 0;
                    }
                } else {
                    apiSelects.length = 0;
                }
                const delApiOption = function(ev) {
                    ev.stopPropagation();
                    let index = Array.prototype.indexOf.call(apiSelectEle.children, this.parentElement);
                    apiSelects.splice(index, 1);
                    this.parentElement.remove();
                    localStorage.setItem("APISelect", JSON.stringify(apiSelects));
                    if (!apiSelects.length) apiSelectEle.style.display = "none";
                }
                const appendApiOption = () => {
                    apiSelects.push(apiHost);
                    initApiOption(apiHost);
                    localStorage.setItem("APISelect", JSON.stringify(apiSelects));
                }
                const selApiOption = function(ev) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    apiSelectEle.style.display = "none";
                    let index = Array.prototype.indexOf.call(apiSelectEle.children, this);
                    apiHostEle.value = apiSelects[index];
                    apiHostEle.dispatchEvent(new Event("change"));
                }
                const initApiOption = (api) => {
                    let optionEle = document.createElement("div");
                    optionEle.onclick = selApiOption;
                    let textEle = document.createElement("span");
                    textEle.textContent = api;
                    optionEle.appendChild(textEle);
                    let delEle = document.createElement("div");
                    delEle.className = "delApiOption";
                    delEle.onclick = delApiOption;
                    delEle.innerHTML = `<svg width="24" height="24"><use xlink:href="#closeIcon" /></svg>`;
                    optionEle.appendChild(delEle);
                    apiSelectEle.appendChild(optionEle);
                }
                const initApiSelectEle = () => {
                    apiSelectEle.innerHTML = "";
                    for (let i = 0; i < apiSelects.length; i++) {
                        initApiOption(apiSelects[i]);
                    }
                }
                initApiSelectEle();
                apiHostEle.onfocus = () => {
                    if (apiSelects.length) apiSelectEle.style.display = "block";
                }
                apiHostEle.onblur = (ev) => {
                    if (!(ev.relatedTarget && apiSelectEle.contains(ev.relatedTarget))) apiSelectEle.style.display = "none";
                }
                let localApiHost = localStorage.getItem("APIHost");
                apiHost = apiHostEle.value = envAPIEndpoint || localApiHost || apiHostEle.getAttribute("value") || "";
                apiHostEle.onchange = () => {
                    apiHost = apiHostEle.value;
                    if (apiHost && apiSelects.indexOf(apiHost) === -1) appendApiOption();
                    localStorage.setItem("APIHost", apiHost);
                }
                apiHostEle.dispatchEvent(new Event("change"));
                const keyEle = document.getElementById("keyInput");
                let localKey = localStorage.getItem("APIKey");
                customAPIKey = keyEle.value = envAPIKey || localKey || keyEle.getAttribute("value") || "";
                keyEle.onchange = () => {
                    customAPIKey = keyEle.value;
                    localStorage.setItem("APIKey", customAPIKey);
                }
                keyEle.dispatchEvent(new Event("change"));
                const updateAvatar = () => {
                    setAvatarPre.src = userAvatar;
                    chatlog.querySelectorAll(".request>.chatAvatar").forEach(ele => {
                        ele.children[0].src = userAvatar;
                    })
                }
                let localAvatar = localStorage.getItem("userAvatar");
                userAvatar = setAvatarPre.src = setAvatar.value = localAvatar || setAvatar.getAttribute("value") || "https://images.yiming.sale/Weixin Image_20231117094822.jpg";
                setAvatar.onchange = () => {
                    userAvatar = setAvatar.value;
                    localStorage.setItem("userAvatar", userAvatar);
                    updateAvatar();
                }
                setAvatar.dispatchEvent(new Event("change"));
                let localSystem = localStorage.getItem("system");
                systemEle.onchange = () => {
                    systemRole = systemEle.value;
                    localStorage.setItem("system", systemRole);
                    if (systemRole) {
                        if (data[0] && data[0].role === "system") {
                            data[0].content = systemRole;
                        } else {
                            data.unshift({
                                role: "system",
                                content: systemRole
                            });
                            processIdx(1);
                        }
                    } else if (data[0] && data[0].role === "system") {
                        data.shift();
                        processIdx(-1);
                    }
                    updateChats();
                }
                if (systemRole === void 0) {
                    systemRole = systemEle.value = localSystem || presetRoleData.default || "";
                    if (systemRole) {
                        data.unshift({
                            role: "system",
                            content: systemRole
                        });
                        processIdx(1);
                        updateChats();
                    }
                }
                preEle.onchange = () => {
                    let val = preEle.value;
                    if (val && presetRoleData[val]) {
                        systemEle.value = presetRoleData[val];
                    } else {
                        systemEle.value = "";
                    }
                    systemEle.dispatchEvent(new Event("change"));
                    systemEle.focus();
                }
                const topEle = document.getElementById("top_p");
                let localTop = localStorage.getItem("top_p");
                topEle.value = roleNature = parseFloat(localTop || topEle.getAttribute("value"));
                topEle.oninput = () => {
                    topEle.style.backgroundSize = (topEle.value - topEle.min) * 100 / (topEle.max - topEle.min) + "% 100%";
                    roleNature = parseFloat(topEle.value);
                    localStorage.setItem("top_p", topEle.value);
                }
                topEle.dispatchEvent(new Event("input"));
                const tempEle = document.getElementById("temp");
                let localTemp = localStorage.getItem("temp");
                tempEle.value = roleTemp = parseFloat(localTemp || tempEle.getAttribute("value"));
                tempEle.oninput = () => {
                    tempEle.style.backgroundSize = (tempEle.value - tempEle.min) * 100 / (tempEle.max - tempEle.min) + "% 100%";
                    roleTemp = parseFloat(tempEle.value);
                    localStorage.setItem("temp", tempEle.value);
                }
                tempEle.dispatchEvent(new Event("input"));
                const convWEle = document.getElementById("convWidth");
                const styleSheet = document.styleSheets[0];
                convWEle.oninput = () => {
                    let type = isFull ? 1 : 0;
                    convWEle.style.backgroundSize = (convWEle.value - convWEle.min) * 100 / (convWEle.max - convWEle.min) + "% 100%";
                    convWidth[type] = parseInt(convWEle.value);
                    localStorage.setItem("convWidth" + type, convWEle.value);
                    styleSheet.deleteRule(0);
                    styleSheet.deleteRule(0);
                    styleSheet.insertRule(`.bottom_wrapper{max-width:${convWidth[type]}%;}`, 0);
                    styleSheet.insertRule(`.requestBody,.response .markdown-body{max-width:calc(${convWidth[type]}% - 88px);}`, 0);
                }
                const setConvValue = () => {
                    let type = isFull ? 1 : 0;
                    let localConv = localStorage.getItem("convWidth" + type);
                    convWEle.value = parseInt(localConv || (type ? "60" : "100"));
                    convWEle.dispatchEvent(new Event("input"));
                }
                const fullFunc = () => {
                    isFull = windowEle.classList.contains("full_window");
                    localStorage.setItem("fullWindow", isFull);
                    setConvValue();
                    toggleFull.title = isFull ? translations[locale]["winedWin"] : translations[locale]["fullWin"];
                    toggleFull.children[0].children[0].setAttributeNS("http://www.w3.org/1999/xlink", "href", isFull ? "#collapseFullIcon" : "#expandFullIcon");
                }
                toggleFull.onclick = () => {
                    windowEle.classList.toggle("full_window");
                    fullFunc();
                }
                let localFull = localStorage.getItem("fullWindow");
                if (localFull && localFull === "true") {
                    if (!windowEle.classList.contains("full_window")) {
                        windowEle.classList.add("full_window");
                        fullFunc();
                    }
                } else if (windowEle.classList.contains("full_window")) {
                    windowEle.classList.remove("full_window");
                    fullFunc();
                } else {
                    setConvValue();
                }
                const speedEle = document.getElementById("textSpeed");
                let localSpeed = localStorage.getItem("textSpeed");
                speedEle.value = localSpeed || speedEle.getAttribute("value");
                textSpeed = parseFloat(speedEle.min) + (speedEle.max - speedEle.value);
                speedEle.oninput = () => {
                    speedEle.style.backgroundSize = (speedEle.value - speedEle.min) * 100 / (speedEle.max - speedEle.min) + "% 100%";
                    textSpeed = parseFloat(speedEle.min) + (speedEle.max - speedEle.value);
                    localStorage.setItem("textSpeed", speedEle.value);
                }
                speedEle.dispatchEvent(new Event("input"));
                if (localStorage.getItem("enableCont") != null) { // fallback old cont
                    if (localStorage.getItem("enableCont") === "false") localStorage.setItem("contLength", 0);
                    localStorage.removeItem("enableCont");
                }
                const contLenEle = document.getElementById("contLength");
                let localContLen = localStorage.getItem("contLength");
                contLenEle.value = contLen = parseInt(localContLen || contLenEle.getAttribute("value"));
                contLenEle.oninput = () => {
                    contLenEle.style.backgroundSize = (contLenEle.value - contLenEle.min) * 100 / (contLenEle.max - contLenEle.min) + "% 100%";
                    contLen = parseInt(contLenEle.value);
                    contLenWrap.textContent = contLen;
                    localStorage.setItem("contLength", contLenEle.value);
                }
                contLenEle.dispatchEvent(new Event("input"));
                const longEle = document.getElementById("enableLongReply");
                let localLong = localStorage.getItem("enableLongReply");
                longEle.checked = enableLongReply = (localLong || longEle.getAttribute("checked")) === "true";
                longEle.onchange = () => {
                    enableLongReply = longEle.checked;
                    localStorage.setItem("enableLongReply", enableLongReply);
                }
                longEle.dispatchEvent(new Event("change"));
                let localPin = localStorage.getItem("pinNav");
                if (window.innerWidth > 800 && !(localPin && localPin === "false")) {
                    document.body.classList.add("show-nav");
                };
                const setDarkTheme = (is) => {
                    let cssEle = document.body.getElementsByTagName("link")[0];
                    cssEle.href = cssEle.href.replace(is ? "light" : "dark", is ? "dark" : "light");
                    let hlCssEle = document.body.getElementsByTagName("link")[1];
                    hlCssEle.href = hlCssEle.href.replace(is ? "github" : "github-dark", is ? "github-dark" : "github");
                    justDarkTheme(is);
                }
                const handleAutoMode = (ele) => {
                    if (ele.checked) {
                        autoThemeMode = parseInt(ele.value);
                        localStorage.setItem("autoThemeMode", autoThemeMode);
                        initAutoTime();
                        if (autoThemeMode) {
                            if (customDarkOut !== void 0) {
                                clearTimeout(customDarkOut);
                                customDarkOut = void 0;
                            }
                            setDarkTheme(darkMedia.matches);
                        } else {
                            checkCustomTheme();
                        }
                    }
                }
                autoTheme0.onchange = autoTheme1.onchange = function() {
                    handleAutoMode(this)
                };
                const handleAutoTime = (ele, idx) => {
                    let otherIdx = 1 - idx;
                    if (ele.value !== customDarkTime[otherIdx]) {
                        customDarkTime[idx] = ele.value;
                        localStorage.setItem("customDarkTime", JSON.stringify(customDarkTime));
                        checkCustomTheme();
                    } else {
                        ele.value = customDarkTime[idx];
                        notyf.error(translations[locale]["customDarkTip"]);
                    }
                }
                customStart.onchange = function() {
                    handleAutoTime(this, 0)
                };
                customEnd.onchange = function() {
                    handleAutoTime(this, 1)
                };
                const initAutoTime = () => {
                    customAutoSet.style.display = autoThemeMode === 0 ? "block" : "none";
                    if (autoThemeMode === 0) {
                        customStart.value = customDarkTime[0];
                        customEnd.value = customDarkTime[1];
                    }
                }
                const initAutoThemeEle = () => {
                    autoThemeEle.querySelector("#autoTheme" + autoThemeMode).checked = true;
                    initAutoTime();
                }
                const checkCustomTheme = () => {
                    if (customDarkOut !== void 0) clearTimeout(customDarkOut);
                    let date = new Date();
                    let nowTime = date.getTime();
                    let start = customDarkTime[0].split(":");
                    let startTime = new Date().setHours(start[0], start[1], 0, 0);
                    let end = customDarkTime[1].split(":");
                    let endTime = new Date().setHours(end[0], end[1], 0, 0);
                    let order = endTime > startTime;
                    let isDark = order ? (nowTime > startTime && endTime > nowTime) : !(nowTime > endTime && startTime > nowTime);
                    let nextChange = isDark ? endTime - nowTime : startTime - nowTime;
                    if (nextChange < 0) nextChange += dayMs;
                    setDarkTheme(isDark);
                    customDarkOut = setTimeout(() => {
                        checkCustomTheme();
                    }, nextChange);
                }
                const setDarkMode = () => {
                    if (customDarkOut !== void 0) {
                        clearTimeout(customDarkOut);
                        customDarkOut = void 0;
                    }
                    autoThemeEle.style.display = "none";
                    let themeClass, title;
                    if (themeMode === 2) {
                        autoThemeEle.style.display = "block";
                        if (autoThemeMode) {
                            setDarkTheme(darkMedia.matches);
                        } else {
                            checkCustomTheme();
                            initAutoThemeEle();
                        }
                        themeClass = "autoTheme";
                        title = translations[locale]["autoTheme"];
                    } else if (themeMode === 1) {
                        setDarkTheme(false);
                        themeClass = "lightTheme";
                        title = translations[locale]["lightTheme"];
                    } else {
                        setDarkTheme(true);
                        themeClass = "darkTheme";
                        title = translations[locale]["darkTheme"];
                    }
                    localStorage.setItem("themeMode", themeMode);
                    setLightEle.className = "setDetail themeDetail " + themeClass;
                    lightEle.children[0].children[0].setAttributeNS("http://www.w3.org/1999/xlink", "href", "#" + themeClass + "Icon");
                    lightEle.title = title;
                }
                lightEle.onclick = () => {
                    themeMode = themeMode - 1;
                    if (themeMode === -1) themeMode = 2;
                    setDarkMode();
                }
                setLightEle.onclick = (ev) => {
                    let idx = Array.prototype.indexOf.call(setLightEle.children, ev.target);
                    if (themeMode !== idx) {
                        themeMode = idx;
                        setDarkMode();
                    }
                }
                let localTheme = localStorage.getItem("themeMode");
                themeMode = parseInt(localTheme || "1");
                let localAutoTheme = localStorage.getItem("autoThemeMode");
                autoThemeMode = parseInt(localAutoTheme || "1");
                let localCustomDark = localStorage.getItem("customDarkTime");
                customDarkTime = JSON.parse(localCustomDark || '["21:00", "07:00"]');
                setDarkMode();
                darkMedia.onchange = e => {
                    if (themeMode === 2 && autoThemeMode) setDarkTheme(e.matches);
                };
                const caseSearchEle = document.getElementById("matchCaseSearch");
                let localSearchFlag = localStorage.getItem("searchFlag") || "0";
                isCaseSearch = Boolean(localSearchFlag & 1);
                caseSearchEle.classList.toggle("seledSearch", isCaseSearch);
                caseSearchEle.onclick = () => {
                    isCaseSearch = caseSearchEle.classList.toggle("seledSearch");
                    localStorage.setItem("searchFlag", ~~isCaseSearch);
                    if (searchChatEle.value.length) toSearchChats();
                }
            };
            initSetting();
            document.getElementById("loadMask").style.display = "none";
            const closeEvent = (ev) => {
                if (settingEle.contains(ev.target)) return;
                if (!dialogEle.contains(ev.target)) {
                    dialogEle.style.display = "none";
                    document.removeEventListener("mousedown", closeEvent, true);
                    settingEle.classList.remove("showSetting");
                    stopTestVoice();
                }
            }
            settingEle.onmousedown = () => {
                dialogEle.style.display = dialogEle.style.display === "block" ? "none" : "block";
                if (dialogEle.style.display === "block") {
                    document.addEventListener("mousedown", closeEvent, true);
                    settingEle.classList.add("showSetting");
                } else {
                    document.removeEventListener("mousedown", closeEvent, true);
                    settingEle.classList.remove("showSetting");
                }
            }
            let delayId;
            const delay = () => {
                return new Promise((resolve) => delayId = setTimeout(resolve, textSpeed)); //打字机时间间隔
            }
            const uuidv4 = () => {
                let uuid = ([1e7] + 1e3 + 4e3 + 8e3 + 1e11).replace(/[018]/g, c =>
                    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                );
                return existVoice === 3 ? uuid.toUpperCase() : uuid;
            }
            const getTime = () => {
                return existVoice === 3 ? new Date().toISOString() : new Date().toString();
            }
            const getWSPre = (date, requestId) => {
                let osPlatform = (typeof window !== "undefined") ? "Browser" : "Node";
                osPlatform += "/" + navigator.platform;
                let osName = navigator.userAgent;
                let osVersion = navigator.appVersion;
                return `Path: speech.config\r\nX-RequestId: ${requestId}\r\nX-Timestamp: ${date}\r\nContent-Type: application/json\r\n\r\n{"context":{"system":{"name":"SpeechSDK","version":"1.26.0","build":"JavaScript","lang":"JavaScript","os":{"platform":"${osPlatform}","name":"${osName}","version":"${osVersion}"}}}}`
            }
            const getWSAudio = (date, requestId) => {
                return existVoice === 3 ? `Path: synthesis.context\r\nX-RequestId: ${requestId}\r\nX-Timestamp: ${date}\r\nContent-Type: application/json\r\n\r\n{"synthesis":{"audio":{"metadataOptions":{"sentenceBoundaryEnabled":false,"wordBoundaryEnabled":false},"outputFormat":"${voiceFormat}"}}}` :
                    `X-Timestamp:${date}\r\nContent-Type:application/json; charset=utf-8\r\nPath:speech.config\r\n\r\n{"context":{"synthesis":{"audio":{"metadataoptions":{"sentenceBoundaryEnabled":"false","wordBoundaryEnabled":"true"},"outputFormat":"${voiceFormat}"}}}}`
            }
            const getWSText = (date, requestId, lang, voice, volume, rate, pitch, style, role, msg) => {
                let fmtVolume = volume === 1 ? "+0%" : volume * 100 - 100 + "%";
                let fmtRate = (rate >= 1 ? "+" : "") + (rate * 100 - 100) + "%";
                let fmtPitch = (pitch >= 1 ? "+" : "") + (pitch - 1) + "Hz";
                msg = getEscape(msg);
                if (existVoice === 3) {
                    let fmtStyle = style ? ` style="${style}"` : "";
                    let fmtRole = role ? ` role="${role}"` : "";
                    let fmtExpress = fmtStyle + fmtRole;
                    return `Path: ssml\r\nX-RequestId: ${requestId}\r\nX-Timestamp: ${date}\r\nContent-Type: application/ssml+xml\r\n\r\n<speak version='1.0' xmlns='http://www.w3.org/2001/10/synthesis' xmlns:mstts='https://www.w3.org/2001/mstts' xml:lang='${lang}'><voice name='${voice}'><mstts:express-as${fmtExpress}><prosody pitch='${fmtPitch}' rate='${fmtRate}' volume='${fmtVolume}'>${msg}</prosody></mstts:express-as></voice></speak>`;
                } else {
                    return `X-RequestId:${requestId}\r\nContent-Type:application/ssml+xml\r\nX-Timestamp:${date}Z\r\nPath:ssml\r\n\r\n<speak version='1.0' xmlns='http://www.w3.org/2001/10/synthesis' xmlns:mstts='https://www.w3.org/2001/mstts' xml:lang='${lang}'><voice name='${voice}'><prosody pitch='${fmtPitch}' rate='${fmtRate}' volume='${fmtVolume}'>${msg}</prosody></voice></speak>`;
                }
            }
            const getAzureWSURL = () => {
                return `wss://${azureRegion}.tts.speech.microsoft.com/cognitiveservices/websocket/v1?Authorization=bearer%20${azureToken}`
            }
            const edgeTTSURL = "wss://speech.platform.bing.com/consumer/speech/synthesize/readaloud/edge/v1?trustedclienttoken=6A5AA1D4EAFF4E9FB37E23D68491D6F4";
            const resetSpeakIcon = () => {
                if (currentVoiceIdx !== void 0) {
                    chatlog.children[systemRole ? currentVoiceIdx - 1 : currentVoiceIdx].classList.remove("showVoiceCls");
                    chatlog.children[systemRole ? currentVoiceIdx - 1 : currentVoiceIdx].lastChild.lastChild.className = "voiceCls readyVoice";
                }
            }
            const endSpeak = () => {
                resetSpeakIcon();
                currentVoiceIdx = void 0;
                if (voiceIns && voiceIns instanceof Audio) {
                    voiceIns.pause();
                    voiceIns.currentTime = 0;
                    URL.revokeObjectURL(voiceIns.src);
                    voiceIns.removeAttribute("src");
                    voiceIns.onended = voiceIns.onerror = null;
                    sourceBuffer = void 0;
                    speechPushing = false;
                    if (voiceSocket && voiceSocket["pending"]) {
                        voiceSocket.close()
                    }
                    if (autoVoiceSocket && autoVoiceSocket["pending"]) {
                        autoVoiceSocket.close()
                    }
                    speechQuene.length = 0;
                    autoMediaSource = void 0;
                    voiceContentQuene = [];
                    voiceEndFlagQuene = [];
                    voiceBlobURLQuene = [];
                    autoOnlineVoiceFlag = false;
                } else if (supportSpe) {
                    speechSynthesis.cancel();
                }
            }
            const speakEvent = (ins, force = true, end = false) => {
                return new Promise((res, rej) => {
                    ins.onerror = () => {
                        if (end) {
                            endSpeak();
                        } else if (force) {
                            resetSpeakIcon();
                        }
                        res();
                    }
                    if (ins instanceof Audio) {
                        ins.onended = ins.onerror;
                        ins.play();
                    } else {
                        ins.onend = ins.onerror;
                        speechSynthesis.speak(voiceIns);
                    }
                })
            };
            let voiceData = [];
            let voiceSocket;
            let speechPushing = false;
            let speechQuene = [];
            let sourceBuffer;
            speechQuene.push = function(buffer) {
                if (!speechPushing && (sourceBuffer && !sourceBuffer.updating)) {
                    speechPushing = true;
                    sourceBuffer.appendBuffer(buffer);
                } else {
                    Array.prototype.push.call(this, buffer)
                }
            }
            const initSocket = () => {
                return new Promise((res, rej) => {
                    if (!voiceSocket || voiceSocket.readyState > 1) {
                        voiceSocket = new WebSocket(existVoice === 3 ? getAzureWSURL() : edgeTTSURL);
                        voiceSocket.binaryType = "arraybuffer";
                        voiceSocket.onopen = () => {
                            res();
                        };
                        voiceSocket.onerror = () => {
                            rej();
                        }
                    } else {
                        return res();
                    }
                })
            }
            const initStreamVoice = (mediaSource) => {
                return new Promise((r, j) => {
                    Promise.all([initSocket(), new Promise(res => {
                        mediaSource.onsourceopen = () => {
                            res();
                        };
                    })]).then(() => {
                        r();
                    })
                })
            }
            let downQuene = {};
            let downSocket;
            const downBlob = (blob, name) => {
                let a = document.createElement("a");
                a.download = name;
                a.href = URL.createObjectURL(blob);
                a.click();
            }
            const initDownSocket = () => {
                return new Promise((res, rej) => {
                    if (!downSocket || downSocket.readyState > 1) {
                        downSocket = new WebSocket(existVoice === 3 ? getAzureWSURL() : edgeTTSURL);
                        downSocket.binaryType = "arraybuffer";
                        downSocket.onopen = () => {
                            res();
                        };
                        downSocket.onmessage = (e) => {
                            if (e.data instanceof ArrayBuffer) {
                                let text = new TextDecoder().decode(e.data.slice(0, voicePreLen));
                                let reqIdx = text.indexOf(":");
                                let uuid = text.slice(reqIdx + 1, reqIdx + 33);
                                downQuene[uuid]["blob"].push(e.data.slice(voicePreLen));
                            } else if (e.data.indexOf("Path:turn.end") !== -1) {
                                let reqIdx = e.data.indexOf(":");
                                let uuid = e.data.slice(reqIdx + 1, reqIdx + 33);
                                let blob = new Blob(downQuene[uuid]["blob"], {
                                    type: voiceMIME
                                });
                                let key = downQuene[uuid]["key"];
                                let name = downQuene[uuid]["name"];
                                if (blob.size === 0) {
                                    notyf.open({
                                        type: "warning",
                                        message: translations[locale]["cantSpeechTip"]
                                    });
                                    return;
                                }
                                voiceData[key] = blob;
                                if (downQuene[uuid]["isTest"]) {
                                    testVoiceBlob = blob;
                                    playTestAudio();
                                } else {
                                    downBlob(blob, name.slice(0, 16) + voiceSuffix);
                                }
                            }
                        }
                        downSocket.onerror = () => {
                            rej();
                        }
                    } else {
                        return res();
                    }
                })
            }
            let testVoiceBlob;
            let testVoiceIns;
            const playTestAudio = () => {
                if (existVoice >= 2) {
                    if (!testVoiceIns || testVoiceIns instanceof Audio === false) {
                        testVoiceIns = new Audio();
                        testVoiceIns.onended = testVoiceIns.onerror = () => {
                            stopTestVoice();
                        }
                    }
                    testVoiceIns.src = URL.createObjectURL(testVoiceBlob);
                    testVoiceIns.play();
                } else if (supportSpe) {
                    speechSynthesis.speak(testVoiceIns);
                }
            }
            const pauseTestVoice = () => {
                if (testVoiceIns) {
                    if (testVoiceIns && testVoiceIns instanceof Audio) {
                        testVoiceIns.pause();
                    } else if (supportSpe) {
                        speechSynthesis.pause();
                    }
                }
                testVoiceBtn.className = "justSetLine resumeTestVoice";
            }
            const resumeTestVoice = () => {
                if (testVoiceIns) {
                    if (testVoiceIns && testVoiceIns instanceof Audio) {
                        testVoiceIns.play();
                    } else if (supportSpe) {
                        speechSynthesis.resume();
                    }
                }
                testVoiceBtn.className = "justSetLine pauseTestVoice";
            }
            const stopTestVoice = () => {
                if (testVoiceIns) {
                    if (testVoiceIns instanceof Audio) {
                        testVoiceIns.pause();
                        testVoiceIns.currentTime = 0;
                        URL.revokeObjectURL(testVoiceIns.src);
                        testVoiceIns.removeAttribute("src");
                    } else if (supportSpe) {
                        speechSynthesis.cancel();
                    }
                }
                testVoiceBtn.className = "justSetLine readyTestVoice";
            }
            const startTestVoice = async () => {
                testVoiceBtn.className = "justSetLine pauseTestVoice";
                let volume = voiceVolume[voiceType];
                let rate = voiceRate[voiceType];
                let pitch = voicePitch[voiceType];
                let content = voiceTestText;
                if (existVoice >= 2) {
                    let voice = existVoice === 3 ? voiceRole[voiceType].ShortName : voiceRole[voiceType].Name;
                    let style = azureStyle[voiceType];
                    let role = azureRole[voiceType];
                    let key = content + voice + volume + rate + pitch + (style ? style : "") + (role ? role : "");
                    let blob = voiceData[key];
                    if (blob) {
                        testVoiceBlob = blob;
                        playTestAudio();
                    } else {
                        await initDownSocket();
                        let currDate = getTime();
                        let lang = voiceRole[voiceType].lang;
                        let uuid = uuidv4();
                        if (existVoice === 3) {
                            downSocket.send(getWSPre(currDate, uuid));
                        }
                        downSocket.send(getWSAudio(currDate, uuid));
                        downSocket.send(getWSText(currDate, uuid, lang, voice, volume, rate, pitch, style, role, content));
                        downSocket["pending"] = true;
                        downQuene[uuid] = {};
                        downQuene[uuid]["name"] = content;
                        downQuene[uuid]["key"] = key;
                        downQuene[uuid]["isTest"] = true;
                        downQuene[uuid]["blob"] = [];
                    }
                } else {
                    testVoiceIns = new SpeechSynthesisUtterance();
                    testVoiceIns.onend = testVoiceIns.onerror = () => {
                        stopTestVoice();
                    }
                    testVoiceIns.voice = voiceRole[voiceType];
                    testVoiceIns.volume = volume;
                    testVoiceIns.rate = rate;
                    testVoiceIns.pitch = pitch;
                    testVoiceIns.text = content;
                    playTestAudio();
                }
            }
            const downloadAudio = async (idx) => {
                if (existVoice < 2) {
                    return;
                }
                let type = data[idx].role === "user" ? 0 : 1;
                let voice = existVoice === 3 ? voiceRole[type].ShortName : voiceRole[type].Name;
                let volume = voiceVolume[type];
                let rate = voiceRate[type];
                let pitch = voicePitch[type];
                let style = azureStyle[type];
                let role = azureRole[type];
                let content = chatlog.children[systemRole ? idx - 1 : idx].children[1].textContent;
                let key = content + voice + volume + rate + pitch + (style ? style : "") + (role ? role : "");
                let blob = voiceData[key];
                if (blob) {
                    downBlob(blob, content.slice(0, 16) + voiceSuffix);
                } else {
                    await initDownSocket();
                    let currDate = getTime();
                    let lang = voiceRole[type].lang;
                    let uuid = uuidv4();
                    if (existVoice === 3) {
                        downSocket.send(getWSPre(currDate, uuid));
                    }
                    downSocket.send(getWSAudio(currDate, uuid));
                    downSocket.send(getWSText(currDate, uuid, lang, voice, volume, rate, pitch, style, role, content));
                    downSocket["pending"] = true;
                    downQuene[uuid] = {};
                    downQuene[uuid]["name"] = content;
                    downQuene[uuid]["key"] = key;
                    downQuene[uuid]["blob"] = [];
                }
            }
            const NoMSEPending = (key) => {
                return new Promise((res, rej) => {
                    let bufArray = [];
                    voiceSocket.onmessage = (e) => {
                        if (e.data instanceof ArrayBuffer) {
                            bufArray.push(e.data.slice(voicePreLen));
                        } else if (e.data.indexOf("Path:turn.end") !== -1) {
                            voiceSocket["pending"] = false;
                            if (!(bufArray.length === 1 && bufArray[0].byteLength === 0)) {
                                voiceData[key] = new Blob(bufArray, {
                                    type: voiceMIME
                                });
                                res(voiceData[key]);
                            } else {
                                res(new Blob());
                            }
                        }
                    }
                })
            }
            const pauseEv = () => {
                if (voiceIns.src) {
                    let ele = chatlog.children[systemRole ? currentVoiceIdx - 1 : currentVoiceIdx].lastChild.lastChild;
                    ele.classList.remove("readyVoice");
                    ele.classList.remove("pauseVoice");
                    ele.classList.add("resumeVoice");
                }
            }
            const resumeEv = () => {
                if (voiceIns.src) {
                    let ele = chatlog.children[systemRole ? currentVoiceIdx - 1 : currentVoiceIdx].lastChild.lastChild;
                    ele.classList.remove("readyVoice");
                    ele.classList.remove("resumeVoice");
                    ele.classList.add("pauseVoice");
                }
            }
            const speechEvent = async (idx) => {
                if (!data[idx]) return;
                endSpeak();
                currentVoiceIdx = idx;
                if (!data[idx].content && enableContVoice) {
                    if (currentVoiceIdx !== data.length - 1) {
                        return speechEvent(currentVoiceIdx + 1)
                    } else {
                        return endSpeak()
                    }
                };
                let type = data[idx].role === "user" ? 0 : 1;
                chatlog.children[systemRole ? idx - 1 : idx].classList.add("showVoiceCls");
                let voiceIconEle = chatlog.children[systemRole ? idx - 1 : idx].lastChild.lastChild;
                voiceIconEle.className = "voiceCls pauseVoice";
                let content = chatlog.children[systemRole ? idx - 1 : idx].children[1].textContent;
                let volume = voiceVolume[type];
                let rate = voiceRate[type];
                let pitch = voicePitch[type];
                let style = azureStyle[type];
                let role = azureRole[type];
                if (existVoice >= 2) {
                    if (!voiceIns || voiceIns instanceof Audio === false) {
                        voiceIns = new Audio();
                        voiceIns.onpause = pauseEv;
                        voiceIns.onplay = resumeEv;
                    }
                    let voice = existVoice === 3 ? voiceRole[type].ShortName : voiceRole[type].Name;
                    let key = content + voice + volume + rate + pitch + (style ? style : "") + (role ? role : "");
                    let currData = voiceData[key];
                    if (currData) {
                        voiceIns.src = URL.createObjectURL(currData);
                    } else {
                        let mediaSource;
                        if (supportMSE) {
                            mediaSource = new MediaSource;
                            voiceIns.src = URL.createObjectURL(mediaSource);
                            await initStreamVoice(mediaSource);
                            if (!sourceBuffer) {
                                sourceBuffer = mediaSource.addSourceBuffer(voiceMIME);
                            }
                            sourceBuffer.onupdateend = function() {
                                speechPushing = false;
                                if (speechQuene.length) {
                                    let buf = speechQuene.shift();
                                    if (buf["end"]) {
                                        if (!sourceBuffer.buffered.length) notyf.open({
                                            type: "warning",
                                            message: translations[locale]["cantSpeechTip"]
                                        });
                                        mediaSource.endOfStream();
                                    } else {
                                        speechPushing = true;
                                        sourceBuffer.appendBuffer(buf);
                                    }
                                }
                            };
                            let bufArray = [];
                            voiceSocket.onmessage = (e) => {
                                if (e.data instanceof ArrayBuffer) {
                                    let buf = e.data.slice(voicePreLen);
                                    bufArray.push(buf);
                                    speechQuene.push(buf);
                                } else if (e.data.indexOf("Path:turn.end") !== -1) {
                                    voiceSocket["pending"] = false;
                                    if (!(bufArray.length === 1 && bufArray[0].byteLength === 0)) voiceData[key] = new Blob(bufArray, {
                                        type: voiceMIME
                                    });
                                    if (!speechQuene.length && !speechPushing) {
                                        mediaSource.endOfStream();
                                    } else {
                                        let buf = new ArrayBuffer();
                                        buf["end"] = true;
                                        speechQuene.push(buf);
                                    }
                                }
                            }
                        } else {
                            await initSocket();
                        }
                        let currDate = getTime();
                        let lang = voiceRole[type].lang;
                        let uuid = uuidv4();
                        if (existVoice === 3) {
                            voiceSocket.send(getWSPre(currDate, uuid));
                        }
                        voiceSocket.send(getWSAudio(currDate, uuid));
                        voiceSocket.send(getWSText(currDate, uuid, lang, voice, volume, rate, pitch, style, role, content));
                        voiceSocket["pending"] = true;
                        if (!supportMSE) {
                            let blob = await NoMSEPending(key);
                            if (blob.size === 0) notyf.open({
                                type: "warning",
                                message: translations[locale]["cantSpeechTip"]
                            });
                            voiceIns.src = URL.createObjectURL(blob);
                        }
                    }
                } else {
                    voiceIns = new SpeechSynthesisUtterance();
                    voiceIns.voice = voiceRole[type];
                    voiceIns.volume = volume;
                    voiceIns.rate = rate;
                    voiceIns.pitch = pitch;
                    voiceIns.text = content;
                }
                await speakEvent(voiceIns);
                if (enableContVoice) {
                    if (currentVoiceIdx !== data.length - 1) {
                        return speechEvent(currentVoiceIdx + 1)
                    } else {
                        endSpeak()
                    }
                }
            };
            let autoVoiceSocket;
            let autoMediaSource;
            let voiceContentQuene = [];
            let voiceEndFlagQuene = [];
            let voiceBlobURLQuene = [];
            let autoOnlineVoiceFlag = false;
            const autoAddQuene = () => {
                if (voiceContentQuene.length) {
                    let content = getUnescape(md.render(voiceContentQuene.shift()));
                    let currDate = getTime();
                    let uuid = uuidv4();
                    let voice = voiceRole[1].Name;
                    if (existVoice === 3) {
                        autoVoiceSocket.send(getWSPre(currDate, uuid));
                        voice = voiceRole[1].ShortName;
                    }
                    autoVoiceSocket.send(getWSAudio(currDate, uuid));
                    autoVoiceSocket.send(getWSText(currDate, uuid, voiceRole[1].lang, voice, voiceVolume[1], voiceRate[1], voicePitch[1], azureStyle[1], azureRole[1], content));
                    autoVoiceSocket["pending"] = true;
                    autoOnlineVoiceFlag = true;
                }
            }
            const autoSpeechEvent = (content, ele, force = false, end = false) => {
                if (ele.lastChild.lastChild.classList.contains("readyVoice")) {
                    ele.classList.add("showVoiceCls");
                    ele.lastChild.lastChild.className = "voiceCls pauseVoice";
                }
                if (existVoice >= 2) {
                    voiceContentQuene.push(content);
                    voiceEndFlagQuene.push(end);
                    if (!voiceIns || voiceIns instanceof Audio === false) {
                        voiceIns = new Audio();
                        voiceIns.onpause = pauseEv;
                        voiceIns.onplay = resumeEv;
                    }
                    if (!autoVoiceSocket || autoVoiceSocket.readyState > 1) {
                        autoVoiceSocket = new WebSocket(existVoice === 3 ? getAzureWSURL() : edgeTTSURL);
                        autoVoiceSocket.binaryType = "arraybuffer";
                        autoVoiceSocket.onopen = () => {
                            autoAddQuene();
                        };
                        autoVoiceSocket.onerror = () => {
                            autoOnlineVoiceFlag = false;
                        };
                    };
                    let bufArray = [];
                    autoVoiceSocket.onmessage = (e) => {
                        if (e.data instanceof ArrayBuffer) {
                            (supportMSE ? speechQuene : bufArray).push(e.data.slice(voicePreLen));
                        } else {
                            if (e.data.indexOf("Path:turn.end") !== -1) {
                                autoVoiceSocket["pending"] = false;
                                autoOnlineVoiceFlag = false;
                                if (!supportMSE) {
                                    let blob = new Blob(bufArray, {
                                        type: voiceMIME
                                    });
                                    bufArray = [];
                                    if (blob.size) {
                                        let blobURL = URL.createObjectURL(blob);
                                        if (!voiceIns.src) {
                                            voiceIns.src = blobURL;
                                            voiceIns.play();
                                        } else {
                                            voiceBlobURLQuene.push(blobURL);
                                        }
                                    } else {
                                        notyf.open({
                                            type: "warning",
                                            message: translations[locale]["cantSpeechTip"]
                                        });
                                    }
                                    autoAddQuene();
                                }
                                if (voiceEndFlagQuene.shift()) {
                                    if (supportMSE) {
                                        if (!speechQuene.length && !speechPushing) {
                                            autoMediaSource.endOfStream();
                                        } else {
                                            let buf = new ArrayBuffer();
                                            buf["end"] = true;
                                            speechQuene.push(buf);
                                        }
                                    } else {
                                        if (!voiceBlobURLQuene.length && !voiceIns.src) {
                                            endSpeak();
                                        } else {
                                            voiceBlobURLQuene.push("end");
                                        }
                                    }
                                };
                                if (supportMSE) {
                                    autoAddQuene();
                                }
                            }
                        }
                    };
                    if (!autoOnlineVoiceFlag && autoVoiceSocket.readyState) {
                        autoAddQuene();
                    }
                    if (supportMSE) {
                        if (!autoMediaSource) {
                            autoMediaSource = new MediaSource();
                            autoMediaSource.onsourceopen = () => {
                                if (!sourceBuffer) {
                                    sourceBuffer = autoMediaSource.addSourceBuffer(voiceMIME);
                                    sourceBuffer.onupdateend = () => {
                                        speechPushing = false;
                                        if (speechQuene.length) {
                                            let buf = speechQuene.shift();
                                            if (buf["end"]) {
                                                if (!sourceBuffer.buffered.length) notyf.open({
                                                    type: "warning",
                                                    message: translations[locale]["cantSpeechTip"]
                                                });
                                                autoMediaSource.endOfStream();
                                            } else {
                                                speechPushing = true;
                                                sourceBuffer.appendBuffer(buf);
                                            }
                                        }
                                    };
                                }
                            }
                        }
                        if (!voiceIns.src) {
                            voiceIns.src = URL.createObjectURL(autoMediaSource);
                            voiceIns.play();
                            voiceIns.onended = voiceIns.onerror = () => {
                                endSpeak();
                            }
                        }
                    } else {
                        voiceIns.onended = voiceIns.onerror = () => {
                            if (voiceBlobURLQuene.length) {
                                let src = voiceBlobURLQuene.shift();
                                if (src === "end") {
                                    endSpeak();
                                } else {
                                    voiceIns.src = src;
                                    voiceIns.currentTime = 0;
                                    voiceIns.play();
                                }
                            } else {
                                voiceIns.currentTime = 0;
                                voiceIns.removeAttribute("src");
                            }
                        }
                    }
                } else {
                    voiceIns = new SpeechSynthesisUtterance(content);
                    voiceIns.volume = voiceVolume[1];
                    voiceIns.rate = voiceRate[1];
                    voiceIns.pitch = voicePitch[1];
                    voiceIns.voice = voiceRole[1];
                    speakEvent(voiceIns, force, end);
                }
            };
            const confirmAction = (prompt) => {
                if (window.confirm(prompt)) {
                    return true
                } else {
                    return false
                }
            };
            let autoVoiceIdx = 0;
            let autoVoiceDataIdx;
            let refreshIdx;
            let currentResEle;
            let progressData = "";
            const streamGen = async (long) => {
                controller = new AbortController();
                controllerId = setTimeout(() => {
                    notyf.error(translations[locale]["timeoutTip"]);
                    stopLoading();
                }, 200000);
                let isRefresh = refreshIdx !== void 0;
                if (isRefresh) {
                    currentResEle = chatlog.children[systemRole ? refreshIdx - 1 : refreshIdx];
                    if (outOfMsgWindow(currentResEle)) messagesEle.scrollTo(0, currentResEle.offsetTop)
                } else if (!currentResEle) {
                    currentResEle = createConvEle("response", true, modelVersion);
                    currentResEle.children[1].innerHTML = "<p class='cursorCls'><br /></p>";
                    currentResEle.dataset.loading = true;
                    scrollToBottom();
                }
                let idx = isRefresh ? refreshIdx : data.length;
                if (existVoice && enableAutoVoice && !long) {
                    if (isRefresh) {
                        endSpeak();
                        autoVoiceDataIdx = currentVoiceIdx = idx;
                    } else if (currentVoiceIdx !== data.length) {
                        endSpeak();
                        autoVoiceDataIdx = currentVoiceIdx = idx;
                    }
                };
                try {
                    let dataSlice;
                    if (long) {
                        idx = isRefresh ? refreshIdx : data.length - 1;
                        dataSlice = [data[idx - 1], data[idx]];
                        if (systemRole) dataSlice.unshift(data[0]);
                    } else {
                        let startIdx = idx > contLen ? idx - contLen - 1 : 0;
                        dataSlice = data.slice(startIdx, idx);
                        if (systemRole && startIdx > 0) dataSlice.unshift(data[0]);
                    }
                    dataSlice = dataSlice.map(item => {
                        if (item.role === "assistant") return {
                            role: item.role,
                            content: item.content
                        };
                        else return item;
                    })
                    let headers = {
                        "Content-Type": "application/json"
                    };
                    if (customAPIKey) headers["Authorization"] = "Bearer " + customAPIKey;
                    const res = await fetch(apiHost + ((apiHost.length && !apiHost.endsWith("/")) ? "/" : "") + API_URL, {
                        method: "POST",
                        headers,
                        body: JSON.stringify({
                            messages: dataSlice,
                            model: modelVersion,
                            stream: true,
                            temperature: roleTemp,
                            top_p: roleNature
                        }),
                        signal: controller.signal
                    });
                    clearTimeout(controllerId);
                    controllerId = void 0;
                    if (res.status !== 200) {
                        if (res.status === 401) {
                            notyf.error(translations[locale]["errorAiKeyTip"])
                        } else if (res.status === 400 || res.status === 413) {
                            notyf.error(translations[locale]["largeReqTip"]);
                        } else if (res.status === 404) {
                            notyf.error(translations[locale]["noModelPerTip"]);
                        } else if (res.status === 429) {
                            notyf.error(res.statusText ? translations[locale]["apiRateTip"] : translations[locale]["exceedLimitTip"]);
                        } else {
                            notyf.error(translations[locale]["badGateTip"]);
                        }
                        stopLoading();
                        return;
                    }
                    const decoder = new TextDecoder();
                    const reader = res.body.getReader();
                    const readChunk = async () => {
                        return reader.read().then(async ({
                            value,
                            done
                        }) => {
                            if (!done) {
                                value = decoder.decode(value);
                                let chunks = value.match(/[^\n]+/g);
                                if (!chunks) return readChunk();
                                for (let i = 0; i < chunks.length; i++) {
                                    let chunk = chunks[i];
                                    if (chunk) {
                                        let payload;
                                        try {
                                            payload = JSON.parse(chunk.slice(5));
                                        } catch (e) {
                                            break;
                                        }
                                        if (!payload.choices.length) continue;
                                        if (payload.choices[0].finish_reason) {
                                            let lenStop = payload.choices[0].finish_reason === "length";
                                            let longReplyFlag = enableLongReply && lenStop;
                                            let ele = currentResEle.lastChild.children[0].children[0];
                                            if (!enableLongReply && lenStop) {
                                                ele.className = "halfRefReq optionItem";
                                                ele.title = translations[locale]["continue"]
                                            } else {
                                                ele.className = "refreshReq optionItem";
                                                ele.title = translations[locale]["refresh"]
                                            };
                                            if (existVoice && enableAutoVoice && currentVoiceIdx === autoVoiceDataIdx) {
                                                let voiceText = longReplyFlag ? "" : progressData.slice(autoVoiceIdx),
                                                    stop = !longReplyFlag;
                                                autoSpeechEvent(voiceText, currentResEle, false, stop);
                                            }
                                            break;
                                        } else {
                                            let content = payload.choices[0].delta.content;
                                            if (content) {
                                                if (!progressData && !content.trim()) continue;
                                                if (existVoice && enableAutoVoice && currentVoiceIdx === autoVoiceDataIdx) {
                                                    let spliter = content.match(/\.|\?|!|~|。|？|！|\n/);
                                                    if (spliter) {
                                                        let voiceText = progressData.slice(autoVoiceIdx) + content.slice(0, spliter.index + 1);
                                                        autoVoiceIdx += voiceText.length;
                                                        autoSpeechEvent(voiceText, currentResEle);
                                                    }
                                                }
                                                if (progressData) await delay();
                                                progressData += content;
                                                currentResEle.children[1].innerHTML = md.render(progressData);
                                                scrollToBottom();
                                            }
                                        }
                                    }
                                }
                                return readChunk();
                            } else {
                                if (isRefresh) {
                                    data[refreshIdx].content = progressData;
                                    if (longReplyFlag) return streamGen(true);
                                } else {
                                    if (long) {
                                        data[data.length - 1].content = progressData
                                    } else {
                                        data.push({
                                            role: "assistant",
                                            content: progressData,
                                            model: modelVersion
                                        })
                                    }
                                    if (longReplyFlag) return streamGen(true);
                                }
                                stopLoading(false);
                            }
                        });
                    };
                    await readChunk();
                } catch (e) {
                    if (e.message.indexOf("aborted") === -1) {
                        notyf.error(translations[locale]["badEndpointTip"])
                        stopLoading();
                    }
                }
            };
            const loadAction = (bool) => {
                loading = bool;
                sendBtnEle.disabled = bool;
                sendBtnEle.className = bool ? " loading" : "loaded";
                stopEle.style.display = bool ? "flex" : "none";
                textInputEvent();
            };
            const updateChatPre = () => {
                let ele = activeChatEle.children[1].children[1];
                let first = data.find(item => {
                    return item.role === "assistant"
                });
                ele.textContent = first ? first.content.slice(0, 30) : "";
                forceRepaint(ele.parentElement)
            }
            const stopLoading = (abort = true) => {
                stopEle.style.display = "none";
                if (currentResEle.children[1].querySelector(".cursorCls")) currentResEle.children[1].innerHTML = "<br />";
                if (abort) {
                    controller.abort();
                    if (controllerId) clearTimeout(controllerId);
                    if (delayId) clearTimeout(delayId);
                    if (refreshIdx !== void 0) {
                        data[refreshIdx].content = progressData
                    } else if (data[data.length - 1].role === "assistant") {
                        data[data.length - 1].content = progressData
                    } else {
                        data.push({
                            role: "assistant",
                            content: progressData,
                            model: modelVersion
                        })
                    }
                    if (existVoice && enableAutoVoice && currentVoiceIdx === autoVoiceDataIdx && progressData.length) {
                        let voiceText = progressData.slice(autoVoiceIdx);
                        autoSpeechEvent(voiceText, currentResEle, false, true);
                    }
                }
                if (activeChatEle.children[1].children[1].textContent === "") updateChatPre();
                updateChats();
                controllerId = delayId = refreshIdx = autoVoiceDataIdx = void 0;
                autoVoiceIdx = 0;
                currentResEle.dataset.loading = false;
                currentResEle = null;
                progressData = "";
                loadAction(false);
            };
            const generateText = (message) => {
                loadAction(true);
                let requestEle;
                let isBottom = isContentBottom();
                if (editingIdx !== void 0) {
                    let idx = editingIdx;
                    let eleIdx = systemRole ? idx - 1 : idx;
                    requestEle = chatlog.children[eleIdx];
                    data[idx].content = message;
                    resumeSend();
                    if (idx !== data.length - 1) {
                        requestEle.children[1].textContent = message;
                        if (data[idx + 1].role !== "assistant") {
                            if (currentVoiceIdx !== void 0) {
                                if (currentVoiceIdx > idx) {
                                    currentVoiceIdx++
                                }
                            }
                            data.splice(idx + 1, 0, {
                                role: "assistant",
                                content: "",
                                model: modelVersion
                            });
                            chatlog.insertBefore(createConvEle("response", false, modelVersion), chatlog.children[eleIdx + 1]);
                        }
                        chatlog.children[eleIdx + 1].children[1].innerHTML = "<p class='cursorCls'><br /></p>";
                        chatlog.children[eleIdx + 1].dataset.loading = true;
                        idx = idx + 1;
                        data[idx].content = "";
                        if (idx === currentVoiceIdx) {
                            endSpeak()
                        };
                        refreshIdx = idx;
                        updateChats();
                        streamGen();
                        return;
                    }
                } else {
                    requestEle = createConvEle("request");
                    data.push({
                        role: "user",
                        content: message
                    });
                }
                requestEle.children[1].textContent = message;
                if (chatsData[activeChatIdx].name === translations[locale]["newChatName"]) {
                    if (message.length > 20) message = message.slice(0, 17) + "...";
                    chatsData[activeChatIdx].name = message;
                    activeChatEle.children[1].children[0].textContent = message;
                }
                updateChats();
                if (isBottom) messagesEle.scrollTo(0, messagesEle.scrollHeight);
                streamGen();
            };
            inputAreaEle.onkeydown = (e) => {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    genFunc();
                } else if (keepListenMic && recing) {
                    resetRecRes();
                }
            };
            const genFunc = function() {
                clearAutoSendTimer();
                if (!keepListenMic && recing) {
                    toggleRecEv();
                }
                let message = inputAreaEle.value.trim();
                if (message.length !== 0 && noLoading()) {
                    inputAreaEle.value = "";
                    inputAreaEle.style.height = "47px";
                    if (keepListenMic && recing) resetRecRes();
                    generateText(message);
                }
            };
            sendBtnEle.onclick = genFunc;
            stopEle.onclick = stopLoading;
            clearEle.onclick = () => {
                if (editingIdx === void 0) {
                    if (noLoading() && confirmAction(translations[locale]["clearChatTip"])) {
                        endSpeak();
                        if (systemRole) {
                            data.length = 1
                        } else {
                            data.length = 0
                        }
                        chatlog.innerHTML = "";
                        updateChatPre();
                        updateChats();
                    }
                } else {
                    resumeSend();
                }
            }
        </script>
        <link crossorigin="anonymous" href="//cdn.staticfile.org/KaTeX/0.16.9/katex.min.css" rel="stylesheet">
        <script defer>
            let downRoleController = new AbortController();
            const loadPrompt = () => {
                downRoleController.abort();
                downRoleController = new AbortController();
                setTimeout(() => {
                    downRoleController.abort();
                }, 10000);
                preEle.options.length = 5;
                if (locale === "zh") {
                    fetch("https://cdn.jsdelivr.net/gh/PlexPt/awesome-chatgpt-prompts-zh/prompts-zh.json", {
                        signal: downRoleController.signal
                    }).then(async (response) => {
                        let res = await response.json();
                        for (let i = 0; i < res.length; i++) {
                            let key = "act" + i;
                            presetRoleData[key] = res[i].prompt.trim();
                            let optionEle = document.createElement("option");
                            optionEle.text = res[i].act;
                            optionEle.value = key;
                            preEle.options.add(optionEle);
                        }
                    }).catch(e => {})
                } else {
                    fetch("https://cdn.jsdelivr.net/gh/f/awesome-chatgpt-prompts/prompts.csv", {
                        signal: downRoleController.signal
                    }).then(async (response) => {
                        let res = await response.text();
                        let arr = res.split("\n");
                        for (let i = 1; i < arr.length - 1; i++) {
                            let key = "act" + i;
                            let index = arr[i].indexOf(",");
                            presetRoleData[key] = arr[i].slice(index + 2, -1);
                            let optionEle = document.createElement("option");
                            optionEle.text = arr[i].slice(1, index - 1);
                            optionEle.value = key;
                            preEle.options.add(optionEle);
                        }
                    }).catch(e => {})
                }
            }
            loadPrompt();
        </script>
    </body>

    </html>
<?php
}
?>