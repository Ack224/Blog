# Nowoczesna Platforma Blogowa (Laravel)

Szybki, wydajny i minimalistyczny system zarządzania treścią (CMS) zbudowany w oparciu o Laravel 12 oraz Filament v5. Koncentruje się na dostarczaniu płynnego interfejsu (UX), rozwiniętych interakcjach społecznościowych i modularnej architekturze.

## Technologie

- **Backend:** PHP 8.2+, Laravel 12
- **Panel Administratora:** Filament 5
- **Frontend:** Tailwind CSS 4, Vite
- **Baza Danych:** SQLite (domyślnie), pełne wsparcie dla MySQL/PostgreSQL
- **Testy:** Pest 4

## Główne Funkcje

- **Uwierzytelnianie:** W pełni autorski, bezpieczny proces logowania z systemem weryfikacji adresu e-mail.
- **Interakcje Społecznościowe:** Profile użytkowników, funkcja obserwowania (follow/unfollow), zakładki, system komentarzy z odpowiedziami oraz licznik polubień wpisów.
- **Dystrybucja Treści:** Publiczna lista postów zawierająca zaawansowaną wyszukiwarkę w czasie rzeczywistym oraz filtrowanie indeksowe po kategoriach i tagach.
- **Moderacja:** Zarządzanie widocznością artykułów (szkic vs. opublikowane) oraz zatwierdzanie najnowszych komentarzy panelu administracyjnym.
- **Umiędzynarodowienie:** Natywna obsługa dwóch pełnych wariantów językowych (polskiego i angielskiego).
- **Interfejs (UI/UX):** Przystępny dla urządzeń mobilnych layout z mechanizmem ciemnego i jasnego motywu widoku.
- **SEO & Narzędzia:** Subskrypcja na darmowy newsletter (double opt-in), generowanie meta tagów pozycjonujących, dynamiczna mapa sitemap.xml.

## Uruchomienie Lokalne (Local Setup)

1. **Skopiuj repozytorium i przejdź do katalogu projektu:**
   ```bash
   git clone https://github.com/zstio-pt/blog-2
   cd blog-2
   ```

2. **Zainstaluj wymagane frameworki:**
   ```bash
   composer install
   npm install
   ```

3. **Skompiluj statyczny frontend:**
   ```bash
   npm run build
   ```

4. **Skonfiguruj klucz uwierzytelniania w `.env`:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Przygotuj bazę danych, ustrukturyzuj linki i utwórz użytkownika (admina):**
   ```bash
   php artisan storage:link
   php artisan migrate --seed
   ```

6. **Rozpocznij pracę nad projektem (tryb lokalny):**
   ```bash
   composer run serve
   ```
   *(Aplikacja jest domyślnie dostępna pod portem testowym: `http://127.0.0.1:9001` . Jeśli zajmujesz się wizualnymi kaskadami na froncie, pamiętaj, aby w nowej zakładce użyć `composer run dev`)*.

## Środowisko Testowe (Pest)
Żeby uruchomić proces asercji zautomatyzowanych testów Pest:
```bash
php artisan test
```

## Formatowanie Skryptów (Pint)
```bash
vendor/bin/pint
```

## Przydatne Ścieżki
- `/` - Główna strona ze skryptem najpopularniejszych ogłoszeń tygodnia.
- `/blog` - Centralne repozytorium/widok najnowszych artykułów
- `/posts/{slug}` - Szczegóły opublikowanych widocznych artykułów.
- `/contact` - Statyczna makieta strony kontaktowej
- `/bookmarks` - Archiwum zapisanych przez zweryfikowanego użytkownika lektur.
- `/admin` - Zaplecze administracyjne z panelem wizualnym (wymaga uprawnienia "admin").
- `/sitemap.xml` - Indeksowanie SEO.
