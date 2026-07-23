export function applyTheme(mode = 'system') {
    

    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches

    const isDark =
        mode === 'dark'
            ? true
            : mode === 'light'
                ? false
                : prefersDark

    document.documentElement.classList.toggle('dark', isDark)
}
