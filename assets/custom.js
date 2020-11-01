document.addEventListener('DOMContentLoaded', _ => {
    const isApiDocPage = window.location.pathname.includes("/classboehm__s_1_1F");
    const searchInput = document.getElementById('MSearchField');

    if (isApiDocPage) {
        const contentsDiv = document.getElementsByClassName('contents')[0];
        const memtitles   = Array.from(contentsDiv.getElementsByClassName('memtitle'));
        const memitems    = Array.from(contentsDiv.getElementsByClassName('memitem'));

        const cards = memtitles.map((memtitle, i) => {
            const memitem = memitems[i];
            const method = memtitle.childNodes[1].textContent;

            return { memtitle, memitem, method };
        }, {});

        let lastCard = cards[0];

        const displayCard = card => {
            card.memitem.setAttribute('style', `display: table !important`);
            card.memtitle.setAttribute('style', `display: block !important`);
        };

        const hideCard = card => {
            card.memitem.setAttribute('style', `display: none !important`);
            card.memtitle.setAttribute('style', `display: none !important`);
        };

        const resetCards = e => cards.forEach(displayCard) && lastCard.memtitle.scrollIntoView();

        const searchInputHandler = e => {
            const cardsToDisplay = cards.filter(card => card.method.includes(searchInput.value));
            const cardsToHide = cards.filter(card => !card.method.includes(searchInput.value));

            cardsToDisplay.forEach(displayCard);
            cardsToHide.forEach(hideCard);

            lastCard = cardsToDisplay[0];
            lastCard.memtitle.scrollIntoView();
        };

        searchInput.oninput = searchInputHandler;
        searchInput.addEventListener('focusout', resetCards);
        searchInput.onchange = null;
        searchInput.onkeyup = null;

        const paramsContainers = Array.from(contentsDiv.querySelectorAll('dl.params'));

        paramsContainers.forEach(paramContainer => {
            paramContainer.classList.toggle('hide');
            const paramElem = paramContainer.getElementsByTagName('dt')[0];

            paramElem.onclick = e => {
                paramContainer.classList.toggle('hide');
            };
        });
    }
});
