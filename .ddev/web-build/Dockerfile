RUN URL=$(curl -s -f https://api.github.com/repos/mozilla/geckodriver/releases/latest | jq -r '.assets[].browser_download_url | select(contains("linux64") and endswith("gz"))') && \
    curl -s -L $URL | tar -xz && \
    mv geckodriver /usr/local/bin/ && \
    chmod +x /usr/local/bin/geckodriver
