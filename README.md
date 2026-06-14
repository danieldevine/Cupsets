# Cupsets

over/under engineered throwaway app to generate a league table from a family world cup sweep stake.

## Notes:

- Requires an API key from football-data.org
- requires php 8.5+
- uses views from the Tempest framework as a stand-alone module, with some customisation to get it to work.
- SQLite
- Needs Redis to cache the API requests

## Concept

Based on a snake draft where 20 players picked 2 teams each. Players get 3 points when either of their teams win, goal
difference is calculated across both teams. League order is based on points, with goal difference as a tie breaker and
draft order as the final tie breaker (later first picks coem before earlier first picks).
