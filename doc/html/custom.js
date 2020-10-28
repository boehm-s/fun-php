document.addEventListener('DOMContentLoaded', _ => {
    const isApiDocPage = window.location.pathname == "/classboehm__s_1_1F.html";
    const searchInput = document.getElementById('MSearchField');

    if (isApiDocPage) {
        const contentsDiv = document.getElementsByClassName('contents')[0];
        const firstA      = contentsDiv.getElementsByTagName('a')[0];
        const memtitles   = Array.from(contentsDiv.getElementsByClassName('memtitle'));
        const memitems    = Array.from(contentsDiv.getElementsByClassName('memitem'));

        const cards = memtitles.map((memtitle, i) => {
            const memitem = memitems[i];
            const method = memtitle.childNodes[1].textContent;

            return { memtitle, memitem, method };
        }, {});

        const searchInputHandler = e => {
            cards.forEach(card => {
                const matchesInput = card.method.includes(searchInput.value);
                const displayTitle = matchesInput ? 'block !important' : 'none !important';
                const displayItem  = matchesInput ? 'table !important' : 'none !important';

                card.memitem.setAttribute('style', `display: ${displayItem}`);
                card.memtitle.setAttribute('style', `display: ${displayTitle}`);
                card.memtitle.scrollIntoView();
            });
        };
        searchInput.oninput = null;
        searchInput.onchange = null;
        searchInput.onkeyup = searchInputHandler;
    }
});
