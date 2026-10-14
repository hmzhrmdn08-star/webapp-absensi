-- Jalankan sekali di Supabase Dashboard > SQL Editor > New query.
create table if not exists public.class_data (
  id integer primary key check (id = 1),
  payload jsonb not null default '{"absensi":[],"jadwal":[],"piket":[],"struktur":[],"tugas":[]}'::jsonb,
  updated_at timestamptz not null default now()
);

alter table public.class_data enable row level security;

drop policy if exists "Authenticated users can read class data" on public.class_data;
create policy "Authenticated users can read class data"
  on public.class_data for select to authenticated using (true);

drop policy if exists "Authenticated users can insert class data" on public.class_data;
create policy "Authenticated users can insert class data"
  on public.class_data for insert to authenticated with check (true);

drop policy if exists "Authenticated users can update class data" on public.class_data;
create policy "Authenticated users can update class data"
  on public.class_data for update to authenticated using (true) with check (true);
