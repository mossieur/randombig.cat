# randombig.cat

The php code behind [randombig.cat](https://randombig.cat)

[Invite Discord Bot](https://randombig.cat/robot)

## API

On the `GET /roar`, `GET /roar.json`, and `GET /cattes` endpoints, you may add a query parameter called `filter` which should have 1 or more file extensions, separated by commas. When hitting any of the above 3 endpoints with the `filter` param, that endpoint will only return big cats that do not have one of the filtered extensions. There is also an `include` query param that does the opposite of `filter`.

Example: `GET randombig.cat/roar?filter=mp4,webm` will only return big cats that do not have an extension of `mp4` or `webm`.

Example: `GET randombig.cat/roar?include=mp4,webm` will only return big cats that do have an extension of `mp4` or `webm`.
