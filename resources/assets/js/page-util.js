export function scrollToElement(element) {
    return () => {
        if (Boolean(element))
            window.location.href = "#" + element;
    };
}