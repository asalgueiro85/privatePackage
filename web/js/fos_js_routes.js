fos.Router.setData({
    "base_url": "",
    "routes": {
        "app_back_default": {
            "tokens": [["variable", "\/", "[^\/]++", "type"], ["text", "\/action\/backend"], ["variable", "\/", "en|es", "_locale"]],
            "defaults": [],
            "requirements": {"_method": "GET", "_locale": "en|es"},
            "hosttokens": []
        },
        "app_back_search": {
            "tokens": [["text", "\/action\/search"], ["variable", "\/", "en|es", "_locale"]],
            "defaults": [],
            "requirements": {"_method": "POST", "_locale": "en|es"},
            "hosttokens": []
        },
        "notify_action": {
            "tokens": [["text", "\/action\/backend\/notify_action"], ["variable", "\/", "en|es", "_locale"]],
            "defaults": [],
            "requirements": {"_method": "POST", "_locale": "en|es"},
            "hosttokens": []
        },
        "app_back_my_items": {
            "tokens": [["text", "\/action\/backend\/app_back_my_items"], ["variable", "\/", "en|es", "_locale"]],
            "defaults": [],
            "requirements": {"_method": "POST", "_locale": "en|es"},
            "hosttokens": []
        }
    },
    "prefix": "",
    "host": "localhost",
    "scheme": "http"
});