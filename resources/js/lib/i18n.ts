export function t(key: string): string {
    return (window as unknown as { __translations?: Record<string, string> }).__translations?.[key] || key;
}
