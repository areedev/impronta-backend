<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }

    table {
        font-size: x-small;
    }

    table img {
        width: 100%;
        display: block;
    }

    tfoot tr td {
        font-weight: bold;
        font-size: x-small;
    }

    .gray {
        background-color: lightgray
    }

    .tg {
        border-collapse: collapse;
        border-spacing: 0;
    }

    .tg td {
        border-color: black;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        overflow: hidden;
        word-break: normal;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 4px;
    }

    .tg th {
        border-color: black;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: normal;
        overflow: hidden;
        word-break: normal;
    }

    .tg .tg-0pky {
        border-color: inherit;
        text-align: left;
        vertical-align: top
    }

    .grid-container {
        padding: 20px;
        display: grid;
        grid-gap: 20px;
        grid-auto-rows: 1fr;
        grid-template-columns: repeat(2, 1fr);
        grid-auto-flow: dense;
    }

    .item {
        display: flex;
    }

    .item img {
        max-width: 300px;
        height: auto;
    }

    @media screen and (min-width: 40em) and (max-width: 63.99875em) {

        /* 640 ~ 1023 */
        .grid-container {
            grid-template-columns: repeat(1);
        }



    }

    @media print,
    screen and (min-width: 64em) {

        /* 1024+ */
        .grid-container {
            grid-template-columns: repeat(1);
        }

    }
</style>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJ0AAAAwCAYAAAALpHjmAAAgAElEQVR4nO2dd3hc1Z33P7dNH82oV8uS3G254IJNMcSBNZjNUrKhpZBkIbwJhBTYbBYSnrxZSBayC4QkQAKbAIEltCQ4EDoEjAnGBRsjF2RZVtdIGknT586t7x9n5AKEEJGX3WX1fZ55nplbzv2dc7/nV8+RJNd1mcIUPkjI/9UCTOF/H6ZIN4UPHFOkm8IHjinSTeEDxxTppvCBY4p0U/jAoU7mJmnBqe9+geOAPwTeIBQyoPhBVU9GkVfjj5yKLbUgyRaS0UYh+xwuL2Dbm1BkkCTIjsMbT4BlABLg8rHTTyfg8/Hggw8iiUO4oXooqwcjL55rmRCMimOpOHRthuh0qGkBXxAG2mHwdZBU0YAaBn8ErAJICjTMhVAZDPXAYBuUN0FVM7iO+BwcgOJc9Yegvx2G20HyQPUsqGw4JA+A64KigqqB48KB18G2IDcInjI46m9EPx0bbEfcK8vg9Yt7xodhqBOyg+CYUDEfmhfBSA9kEqJfQ2+CmQJkaD5G9H+kG+Jd0LysKMdh8h/xMmWwTTAK4A9D52bIj4hzzcdBtAbyaTG2svS22903n3t3LrwDJkW69wTXEQPpC1+E5r0Cb2Aukgf69nfhJH+BqcuUzfwyNfUnkxkHx9mMa9+AaT74JwdoCh8KTM68Gi5YLhQc0C1xbGISSBJYFiD5CJQ8RbD0DlTPXFQf7HvturXlIzOuO31R/43nrDwwJ7XVT9u2+4hUgCwfjRZ4AK/vVzgIwh4Gx5ki4ocFkyNdRIGQDGUeqAhAwQIHQTjTAI8nRLTqdVTvWhQFIhVwYF/bwtDI1Z//5Cf2Beubbw7PWHDLRWd89Cl5dNcXSKRTlFQKs6L5z6Oi8ZW3PtIyTRRFeb/9ncJ/A0yKdOdO93L2NI1/mB3iyqProMYPSWNCw0FFwx8IRmfj8UBmfAc7/3i11PvysrPXnfTxUUdrGUsk6O/ro3r+srUrZ1UtZ8Ptc9i76QeYegceL4RLV9F62qPiaS6KorJi+XLS6fRfsetT+K/CpEhnOi6GCxnTIWu5fHNxHWpLBIYSEKm+nvK65Rh6nF0vfZZXf3sUBzZfW+kxjf39sTHTNAmFQkSjUcYSSXpiw2M4+RjtL3yTVx+ZRduGr2PkLVpP/BjR2RcBnHPeudTV1ZLJZP66vf9vB1cEHh/yevikAgnbFYGY60LGsHEU+Mq8CDeqagX+6f9EfGAj7ZvPYHT/GC4QmcZY+gBPPvzQs9GA/8rG5hnf9Ab8+tO/f/SK/v7+NkBEckYCerf9EEl6jFlHP0XLsXcsdiP3zmms14eHR5Dld5gjlimiOhB+oGUJE28bQDGYsQywvaBnxXXF6PcgJEVcY+RFJGdb4l7bEsdd50giyJK437YOHXMdca9pCpkm4LiiLShGve/QB8cRck88wnWL0eI7XWuJaNs0DpNlwv91hUxm0erYxb5PtPlOkCRxj20I+Q+HURBymGYx+n179DoZvK/oVZIkbNtitGAzs77mK3d/atXNn/3lUzfy0tNXUFoPWhhsoLIBq7yWITvNbzftvE5+/uXrQiVhutI6VLVCVROYOeh8TaQzcqkONj62ILjub751xemX5Pe1t/9Qct2vW5Z1pACaFyLVkE8W/UkTwmXLKa/9PLLci+y/jmBUJVp9Pb6gj/o5vYx3XIfjiOtFL0RaJ1AaoHrGNfj8PvTsFuK+uwhGGyituRLHlo94aZIMuIPIyvPo2Y0H0y8l5Z+mrHo1hfzhUY+DLBtI0j4yyQcpZOKonkNnbRMUtRVf6FOo2vHIch2OPYxl/RHXeQhT34TrguwRhAtEP0r5tL+nkH+Jvvb78QZEuoackKuk4muU1y/AyN5GbnQn0ZqbAHBd5y0zbeIlqtjG6xTytxOMQp/30CWV9ddQUlWGx9dNIfcD5L+OTz1p0kmShGEYhEIhtbGmZn3DjJmnDQ7FeipeWX/FuCRjewNiljXOglAUCjqo5fSkEzJSWZSUIxMsSVEWMLAN8Adg1kro2Q2qB1RXr93+9NVd8yIfqW9s+ZptWyeYpnkKED+oqtL9MG2RyIM5Dmg6hEqPJVp1CZZpIPuuIxBWiVRcjiTD7BWQGE7Qt+WnuApQJCo2zFn1a6oaTsUFMuObUH134Q83Ea24BMsCb0DkzSbIZxngut+lpvn7JLu+hSxBuOyzRCpOxjTBFzg0WK4rtFMg+j1GutcR794ktHAGgtHLUTw34PWBXMwfSlILjrMK17mcXPr7jA18Cy0MVh6C4XWESy9h+oJLyGf6GB3ciK/0UJ4uVPZ1yiobSQ6+jDfcTt2ML+PYxayCCfmM+O4LgKKJMbAKGczC7UgKFMaFzCXTTqZp8bfJpUUuMDX6OGa+Tcj4/jDpFnRdx+/3q01NTdtLS0tbU8lE7oFf/2ZO6fRmZoQDvDpiQ6BUdErPg8d7HtHKr1PVeDSaV/DGKICZbyObuols4hf4w6DHxadxHvsP7OZ7/3bj6suv+Mf9zc3NS9etW/f63r17jxofHx+WJJCsAu7Qm1A3H/IpYU5sM4FlgGV2CJNng2XqSJKPdAKWnHQbI93PUhjuAMBMQMuqL1PTfCqZpCCXbfXgOGDbOqYFuND1xu3k0wlUDXBVKhpPIFS+nJYlV5Ec/QNDe57FtvqQJEjFd7Kv8yFUjwyug6KVUtN8EYFIlHnHPENnsJbuVzNEGs+jpOIGbAsyY8/T++bdJIcHCJdVMG3euZRUnEnj3KuwzST7Nv9AEMQawsgL8zlj6VPoL9WTGU8gq0IT2mYnRqERj99HekRn2xNX4gk4mHmLcMVK6mafg2Wk2P3K9zByDoGwiql34EpQyIJZdEFmLLsa2zo8qXw1eu5cNM/buPCXYlKkk2UZTdOYM2fO7/1+f6vX6+WBBx74ws6dO/VIwMeBZARKmiEfB8sM0TDnCfzB48kmYbDjXnLJ7diGQ7hqIeW1n6Zy2s8JlV5GcvjvcKw+HJM5jLPmoovYu28/sVjsUxUVFa/U1tbWXXLJJc99//vfX+i6rjAQY91QPYc/62+4NjgSqCqs/Lsn2HDnLMxxqF44m5lLf4xlCvPkvMX3kSRxfHD//2Fsn7BQsgyD9TD32GeobT6Z5tarGY09i2VZqBoYuY307LwWOyu0nKxAKn4bc495nWAkREn5sWhlTzP/+LtBgpHeh+nbfTZjQ1AYgUI9ZEbvp7z+x8xb/WVqZ1xPPnMfXa/0CV8V4YcFQgFmLX2O3ZuWkdcO+bauA4FIFZEqi57N16EGwMpBsP4jtCw+h5w9hqT8gP7txReqFZP5xba1ktnUzT2BzJjFeOxWyuq/QqDkHMzclzAKY7zP1NWkotdMJkNDQ8N5tbW1a71eL+3t7Xs3btx4n23bjKWzWEo15LPgD/hoat1HsOR4Ol77Ejuel2jf8hl63riR3u0/ZP9rF7Jvi5c3N38KVVtCTVPvhK+1r6ubTL7A6uOPw3GcTSMjI8+PjIwwe/bs1lNPPfUqAEVRUJ0CZMdAebcZKKlIKvTuupKxWILKppm0HH8NsgZzVz2BLwwj3Q8z3HUtXv/bb3ccCEYaCdVDuAEiTSIoiffdjAso2mw0BVxXF/6iXEJlC1TOgYq5EKyDwV0dZJM9KBrkkg6VjfOJVHrIpTKkhs/HH4ZQKSgB4aumhqDj5csYHxzAF4Bpcz+JGhUaTlGhkGknM56hrG4pzYvuOKQ/HPFO8xmDaQug8ehDgYY30IDrgKV7qJ8FC/9O+KJygCP8vVmrvosvBLa1gV3PfpXEQDvBCKi+K7FMUa6b+EwCkyKdLMtUVlbeZBgGJZEIW1/d9PODJ4MNoGlQyMGMpS8RLqth37Zl9O//KWYB/EHwBEH2g8cHkgbD3ffR3z6NZPxaFpx6FUiq4zjcf/+vGOjtxkqPY2bTPw4EAgyPjLB69ervRKPREJJEWJHAzIgI9N3gC0D37p/w5uazcCxoav02Kz+5jXB5C6k47PzDudjm/j85iwu5PhSPCFzCZaJGG4yciAQ49jC2CRIqkgSOlaGQFf0MlkBpDUxfdgLewEzRmLQbX/AEVA3SY89TyFl4/BCMCNKle8EpCO0T63wYzQeus1gMvuQgK1DIPs2+zSdRyENN00XMXHHBwegVxERxbaiafshETtSMkYQ7Eq2ChSeDWzikJVVvDdMWnkd6FGTtDqwcdGy5Dc0HgfBXCJYG8PqFn+cL/uXkYZKka2lp+WgoHK4J+n1YowOZ117d9O9opRCoEQOMCzUtp1MxbTk7nvk/7NvwGh5VRKm+UDHqrIPSagiGoGE24CTAXcrcY79HzYILACzL4sE/bGPDkMn219sesceH2koCfsorKjwrVqz4hOu6BLwKOPp7kNqFaOVShna+QM+upwmXQbh0KaoHtq4/H3PMoazuqLeW30TuzIGy2o9RVrcUX2ApvuAqZq+4iqqmf8RxYGzwDkwdJNmHaUAgspamRXdT3XQ35XV3Ujf7t8w77kUiFSrx3i569wwQjCwEwDZi5NKQSYLmg1CkaJIDiECn0I/rgKJGUVUAB8eB0vr5DHduZuez1+ENQ/OiuymbVUU+uxMk4RY49pHpmyMgCW0dKkOkGIqYtvQyglEw850kh+9HDUOq74eMdCUIRj241ucY6YXxmPhMApPy6crKyv82GgoyNjTwHzc+s/U7qfKli2iY3cWu51LgwIzlECj5GUOdKbpeuR0kCJeD1wtatVgJ4imG5oUclNVdTDD6MxQVMqPQdNS3iO36BZJCureLdC4Y7fWFWreMb1z3hePnXXDUqmO/19g4/QxZlu+yXFfkmJw/k0dyXdD8JQDseOwMyupHqWgIsOPpu0h030/5HDAKb7cXbpF0ja3rUWTx23GFb6ioEDvwAnue/QlKWPw2DfCXtFBe3yLSOAURMGWTBor2PNuf+wLGMEiSjCSDrLUIcuii7XAlGIZYheK64A/PKpJvWPidknhntuWjYQEceOVK9jcfz4xlx9O6+iVMc4zC4ZPwXRLNHq8gjlW8XpJVmo76GnoaMskfM9ILdQtUYvssBvf/B6W1/0ig5EoCqVuR5MM051+GSZGuoqLstJ69bTu+v37TF6hc9hRHHbUWmTH2cAax3RuZt7oMb7CG3t0/AqBuMVQ2N5JP1pEb24TigWwSAiUeqprvpKTyk6gKdL1xNrIWonH+nWjRFsxEJ40Lj2fWikfxBaPpkWT7jf/xwJzv+j0r6uvrTtU0Dde1ij7Le/AvbMtCDYGV0Wl78TPMXvFV9jzzeRQNSirBNv50I7nkAK5jFV+6hWN3oWd/TdcbP0JWwBcRxPf6YaRvMx1bb0PzBmhsvRmvXyWffI3XnlpHfkg47mOxl2m2v0ik4iNo/jIyo2NEakSyt7IBehPie/X0czALYJnbcAyRmQcwchZVLdCzBbY/cgoVjb1EqmeTSx6ZtH43KD5IDR/6Xdt6MdHqAMkh8AeupmnBd1A9KjOWWjgmZMbBG2ogWn0m2dQjkw0oJkXVUp829+m2zp8hN3yb6tK15JOAVMbcYx/CMSE1UoXrwNjgdiQJamYtoaqhm9qZrxAuP518CvyhJdTO2ENZzSfBhZ69l5KIP4zHuxdc8EdmEm2BWSt+jtcXJTsOVdHZ1C+/pb03dmfY7/N5PB4sB951Nh8BF1BAjcJwx2/YePeJAFTOE+mGd4Iki/zZgddXsPMP09n9x3r2bJrO/u0nMnjgR3j9IrBwXdG+ooKZ28ro4F20v3grW9efhKJBad0qps256WB1Y6jzQVLjOsGISuP83xIuV8mnxGRMJ2BaKxzz8YcIREowCpAcuR+nAErxlU2Yz2nLADfHxvtOQVL+vG97RN8kYVkmMH3xNzCy4rgnWEYgGsXjD6GqUTRfFM0rInGkbzEWE+sOJ4HJ5elsG1OSdWS5GtsGXDEAklJVrB0WNUbxTSaGPZSUgccPNc3rCZb8Dn/4dHxBkZyNdZxNvO9hKhrBHw7h2OA4KpVNEIp6yCYBSWgS1RuSZA3JdRxZlpFlkGXpvei5Ilwxwx0VbF0kSEsqID0K7zgJiybbcQ2cYllNckQg5PNBoSCumeiy64CkRCmtFimIRPcGtj72GVaedQ9zjvkayKPsfvpazLjB9sfOZfWn1lM57QQC4W5GB+7FLHSjemopqzmPcNlMXAcOvP5Zul+P41igeidklNEzUNYAPdsgP7KVHb//KsvPvJnkyJ/qvHzEV9uY6DeUNp1GdUsT2QQMdvwtiaEONK98sP+mbuHxrWLOMfcQjC6nqnEpeva19zzs7yzEe0de0uKrG6Jnkdx/GbqUIxABRYF472X4ykDWUkgSRKrn4LrQvXkzvW9OR5KHcYGSytPx+ME0HAbaTyE58jDVTeD1gWk0IMlQSPfQ/Rrse+0yQPiB6UKK3te/1FId+ftUwTB0XUfGxUEtVjE0UL0leHygeVtQFNA84PWpePygeEIgiUBG9QEqlM8R9ykaaL4qvEHQfHXF1b4+PF7h+3g8YqZ7fKJNyQW3uJQLWZhMzVODJwCqpw7bgspGcXxgx73seuFaXBfmH38Nc9ZcgxqARPfvaN90IaaRwB+uo2nhPzFz6S00L/w2odKZGAWd/dsvo/OPvzwYLGnecjwB0HyNKIqIeKvniXM9r/2IfZsfJloFHm81qleMy0TJT1GLY+OrIxASgYQ5Dkg+Wtf8Gs0LRm4DhfzjFHLtpOJ7yYzuRc/sZbSvg65N9zI+0EmkAkprHqCi7szJ8GdSmq4vFnu8ddnRF3y1vPpzNz+zfQF92keIRjvxBDYwYxXkEjEKOZ26uRfQv+Nq7DwUsj1o6mLMwjZUTx16PsFQ52r0XBuSDOkxUVpqXnwZuQxYyTZcF/a+/BjJ7DxgEeXKpksvWHtO86KlF7yyeetjpmmihHzIlo4z1CXKRHr6aUz9UlLxOGYSxgYNPIFL8XpVUsObsTKQM0DxoFRUYysSxHpFJt7juw1J2sZw9270MRju2YvmvRQXh7GhGPmEMF/eAFQ0QGoMUoOi9unoEOu6Hkn6PfG+3YwOQCAsUiBOEtpfuBpZ2UUgUoM35KFqnszImw6JoV8w1Pkb4Dw03wokuQ4YxtS3kBp9mEQshuIHJw84EO/7FV2v95Ie7SE1ComRQ8V/gF1Pno3HfwnJ+FbMnKjITETkmfjTHHjjUvKZFI4DiZgw9arPQyb1Hfa+kiE9+iR6Tmw1sA3hXngDYBeX4O/bcgaOdAL5tIxrj31gpBsaHHyqJFxywaLZs++83q88+e3rfrjOVCuhrhmQxGqN4e6v07z4NvbUnkxm8FlyCVC9MYbaluEL3ITjfAej0A6OUPFj7RBoaGXVWUvZ8rvrDpqrmjqi0wJ751rxvaeffPxTVdNnrjVdmd7e3kcdx8HWvETNDGPZgnDZdL2dgtWOky+at2EHW7oVfxCyI2iqhM8joRsZWiur6ejqJJ23QPbBkLIR1I3EY0iugZsZjTPouRVZgtw4ODlh4iUP+MIwGhM1T1kTwcz44AvgvkAqLlbMWPlD6RxJhnjf/SgjwtFPx4V8gRKwrATjQz/FMX+KbYHHI/xIxwVvCKRRcIvluNTwDgY7d6CnxN4FxSPKVwfhwmDnreSTInI+fH+HkWpnsLMdo3g8Oz5xU4pY5w8wDeEROY6QQVEOW2pVbCObaKN/Xxt2gckuAJgU6cLh8G9wHWNgdNwzfe6SUxe3zvv01p277pW6hnCr5kO0Fka6f0q0+jscc84ztL1QjuwZY+eLkBiK4fWfT7QKcgmI90F5HbSc4GHWildIxAwOvHIliCT0J1e34poFauqPPjVY27R2NJ3FddJs2bLlQYB0Oovs2Hh8YSxXQfE7aBGL3FBKCKtJeCtUCvkEYNA8rYFcoUBuaJiMJWGZBpJr4QsEkMMu2WQfeG1mVTaQdRV0ycB2XdKJAi4OkgyuM46T7C+WxNRDBPH4RMJUz0BeK64MyQk5JKm4aMArNJOqgVX0BWVFRL22ItIrmk8Q2TYP2+RTNJGaVzzDMUU7mhfsAkwoO0kW521DPNN1ICcJ4kiaOCfJglhmHgoARdkVDUxdtDux++kg3vJ8Qz5spc5fhkn5dJZl6ePj49d4PR4ymQxLjj72QiZEHN4D2TRkMtDddhyBEmhdM0plwwkM7oNUn9iltH+rIJydhXD5UhadOEIwHGLDPcfhOsiyzPnnn8+8RUvwRMqRvP4v5XI5qquq2LZt24/i8XhClmUKhQK6ZROwswSMcUqNMRqyA5DoBcciIqWZacapHjuA5JhkDZNkOoPruuSzWXRTxDpeTCrdHNp4B5H8IJakoFkFyp0U5UYCxSkguzYyDoqjow21oeS6xcv4a665nGTu638SJqXpdu7cSSAQuHblypUXAk3Lly/7yLPPPrO8q6trqyy5EN+DU9oCmreT9Pg8XOdV6me/iD+0k+Gen5OI7cTjcwiWzidS8Vmqm1dRyEGs8zjy8a0A0UgJluWwfv16ZsyYMXfatGmnO47DgQMHhh955JFvgKhY+P1+1qxZQz6fxzAMKisrT2tqafl83223XJjL6amsbrBqzdrbEomEs3HjxkvPPPPM7/b19dk7duz4l3PPPfeOxx9/fHtbW9utq09cU1VfX3/bSy9t+FRNTW3V0UcffYckSTNVVZV1XbdefPHF1ZlMJubxFGu8rkvAoxBL6exv7+I95QmnAEySdKWlpWQyGfbs2bNm2bJle1zX9V1wwQX/+ctf/nKOhk1/HnJ6ruiPSHsZ7iklXPY9gqWXM7f2ZmGjipl+24bxoZ+QSXwTScohK0iuiyLLPPDArwBYsWLFrzRNQ5Ik55577jnJNIXn7Louc+fOpbW1lbGxMXRdp7a2dvYxxxzzCRnm3nDDDQtPPPHET5911llffP755zva2tpoaWk5x3Vdq7Oz81+qq6tPu/zyyy+6/PLL74/H48OnnHLKx3ft2uVpbm5eVVNTs3br1q1XeDwe2bIsOZ1O69lsFk3TDo5DTpGQLQsk+4hK0hTeHZMineu6eL1egK7R0dHFyWTyuRkzZs3++FlnPHTLzTefXZBKoLpKOMvhKARKHLLJK8kkr0RS5+PaTVimgzcwgNe3k1wKNLWY41JxK2Yxoo9Tpcmcd/EX71y0dPmSvt7uWKFQOCWZTLYdFF5VWbhwIbFYDNM00XUdwzACmzZt2h2NRsuuuOKK34bD4aNffvnlnZlMJmaaJul0uieXyzmmaTI8PPzHUCj08YsuumjbY489tmJ4eLjHMAwKhYKRTCbjBw4c+KOiKOi6nhsYGEiAWLx6OLyKTDASITue4K9rZz+8mPQiTtd18fv9ZLPZ9vHx8QWKovxs2YK556mtx1xc2LnjdiQXhrugdy/MXSkc1UQM3OTuUCa+uzQUZDArYWUVsQPfdISf5zqirqkreJed9LGVxx77ud6urvsHBga+5PP5EiUlJYyOioTmkiVLKCkpIR6PHySD3++vHhoa6nrhhRcu/Od//ufBW2655Qterzc1b96869/ah0gkMv/JJ5/8RkNDw4ILL7ywOxaLDTiOo+u6Hvf7/dGTTjrpX4PBoBqPx/tM0zxfkqS37dNQZRlZcnllawYn/6eK61M4HO9r7fGExrNdN2XGB8//dVfvt7I1x+0nOOdC+nefhJHPYKegfz8U4pAZYu2qo+afcO6nbw6GQlWvvrzhhvt//8wvGX8TKueLFcOOCXoaFh13fW942j/935/ds+6cJTOeDAWDR0RLE1oulUq9TftEo9Hl/f39sVtvvfXETZs2bbjkkku+m8/nAwCSJHkoOmCappXJsuy57777Lrzqqqv+ob6+fqZpmkYgEGjMZrOpRx99dI2iKNi2TUdHh2zbtvNW0rmui0+T0WSbgqoxhT+P973g3XFcSv1eLFnlNy/v6cSb/CpzFtxMqGQfsnIZfW88TGIArTzEictXV6w8Yc2Wyvr6QD6f56NnnHP3vq7e2LZde58mlxU5Im/1fOYc92OaF3+U9i2b92196sm7O+r43Oc/j+bxYJpCmyxfvpxwOMzo6OhB7SPKYrKqaZrHcRz6+vo2tLa2EgwGa/L5vKeoqXyyLFuSJCFJkhqNRudkMhnWr1+/YN26da97vd6Qrus90Wi07LTTTjNlWZZN07S8Xm9zKpUaKLoVb0NIhQ0jDujGO56fwiG8b9LJsoRfkfi33cOQk0FJ/IiR/rMoKf8Ic455iOqWDQx2/aeZGb1r4aKjyqY11AcGBgYBKCuvZGZD7XHbdu19mvqZH0OZ+/fUzvwcJRUw2q+z45G/BegbGODOu+7mi1+8mHA4DEAgEKCnp4d8/tAfqzEMg4GBgX91HOe2kZERKioqiEQidHR0XGMYxo+z2Sz9/f2ficfjFL+vicViiUAgwPDw8O729vYZuVzOicfjW/v7+1fatl2mqiq6rjuFQiFuWdbbtOoECg40eGX6pgKKP4v3TbqoT+WJN1PQOQ4RP7gmjPWfgqq+geabTVntCVRNP4Gurm/d+/hz825qqd1cWlp6tGnZOIkhduzrvo3mv/kZs1dcLDaWWGIJzcb/PBFLj088p7+/j3+/8SbMQgEQS+YVRcEwDmmWQqFANpvtcxynz3VdLMtC13Wy2WyfZVl9pmmSzWY7JtIrmUymLZfLYRgGfr8f27Z7CoUChUKBdDq9Wdd1VFXFMAxyuRz5fJ63bYMswsXBcr0ghd7vkH7o8b4zkX5Foj2ti00viiIK6ZZpMBpbjGW8gKGLP2k1fXrjiF178y8e+N1KeXzgulIr/dMnfve7aW8mgktZuPJiMqOQz4HjDtO3awW54c3iCdLBT3J8nFxOZPgnNgcpinLwo6oqmqYdTGsUTSiqqh5xjaqqyLJ88PiE9lIUBVmWj7ju8Osnzr3jR5VxJ5mh/9+G9+/TuRBUZOLyYct7xN5InfToGrz+y/EGvkE+VcPsJRc939ux/PkHXv45mtKLFfouy5b9A/mUyDY4xu0YuU7+08wAAABxSURBVCuxzT9RSH5raWYK/xPx/+/v000sNizkb8TmJ0h8Ai2/hrrGtRgN12M7Mj7NwEw/hmW+iOs+DG7XwVrmFD60kKb+eckUPmh8+KvLU/hvhynSTeEDxxTppvCBY4p0U/jAMUW6KXzgmCLdFD5w/D/ieq4pWyMKGwAAAABJRU5ErkJggg=="
                    style="width:150px" />
<h3 style="text-align: center; display:block;">Informe de Evaluación #{{ $evaluacion->id }}</h3>

<h3>Información del Candidato</h3>
<table class="tg" width="100%">
    <tbody>
        <tr>
            <td style="font-weight:bold">Nombre</td>
            <td class="fs-4">{{ $evaluacion->candidato->nombre }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">RUT</td>
            <td class="fs-4">{{ $evaluacion->candidato->rut }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Email</td>
            <td class="fs-4">{{ $evaluacion->candidato->email }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Telefono</td>
            <td class="fs-4">{{ $evaluacion->candidato->telefono }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Empresa Actual</td>
            <td class="fs-4">{{ $evaluacion->candidato->empresa->nombre }}</td>
        </tr>
    </tbody>
</table>
<h3>Información de la Evaluación</h3>
<table class="tg" width="100%">
    <tbody>
        <tr>
            <td style="font-weight:bold;">Cargo:</td>
            <td class="fs-4">{{ $evaluacion->cargo }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Evaluador:</td>
            <td class="fs-4">{{ $evaluacion->evaluador_asignado }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Empresa:</td>
            <td class="fs-4">{{ $evaluacion->empresa->nombre }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Area:</td>
            <td class="fs-4">{{ $evaluacion->area->nombre }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Faena:</td>
            <td class="fs-4">{{ $evaluacion->faena->nombre }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Fecha de Solicitud:</td>
            <td class="fs-4">{{ $evaluacion->fecha_solicitud }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Fecha de Ejecución:</td>
            <td class="fs-4">{{ $evaluacion->fecha_ejecucion }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Fecha de Emisión:</td>
            <td class="fs-4">{{ $evaluacion->fecha_emision }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Equipo:</td>
            <td class="fs-4">{{ $evaluacion->equipo }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Marca:</td>
            <td class="fs-4">{{ $evaluacion->marca }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Modelo:</td>
            <td class="fs-4">{{ $evaluacion->modelo }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Año:</td>
            <td class="fs-4">{{ $evaluacion->year }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold">Perfil de Evaluación</td>
            <td class="fs-4">{{ $evaluacion->perfilEvaluacion->nombre }}</td>
        </tr>
    </tbody>
</table>
<h3>Información de la Evaluación Practica</h3>
@if ($evaluacion->resultado->isNotEmpty())
    @foreach ($evaluacion->perfilEvaluacion->secciones as $llave => $seccion)
        <h5 class="border-bottom border-primary pb-3">Resultados sección:
            {{ $seccion->nombre }}
        </h5>

        <table class="tg">
            <thead>
                <tr>
                    <th style="background: #ddebff">#</th>
                    <th style="background: #ddebff">Item</th>
                    <th style="background: #ddebff">Nota</th>
                    <th style="background: #ddebff">% de evaluación</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach ($seccion->items as $item)
                    @php
                        $resultado = $evaluacion->resultado->where('item_id', $item->id)->first();
                        $brechas = explode(',', $evaluacion->aprobacion->brechas_criticas);

                    @endphp
                    <tr>
                        <td
                            style="{{ in_array($item->competencia->id, $brechas) ? 'background:#fa896b; color:white;' : '' }}">
                            {{ $i }}</td>
                        <td
                            style="{{ in_array($item->competencia->id, $brechas) ? 'background:#fa896b; color:white;' : '' }}">
                            {{ $item->competencia->nombre }}
                            @if ($resultado && $resultado->comentario)
                                <hr>
                                <p><span style="font-weight:bold">Comentarios:</span>
                                    {{ $resultado->comentario }}</p>
                            @endif
                        </td>
                        <td
                            style="{{ in_array($item->competencia->id, $brechas) ? 'background:#fa896b; color:white;' : '' }} text-align:center;">
                            {{ isset($resultado->nota) ? floor($resultado->nota * 10) / 10 : null }}
                            
                        </td>
                        <td
                            style="{{ in_array($item->competencia->id, $brechas) ? 'background:#fa896b; color:white;' : '' }} text-align:center;">
                            {{ isset($resultado->porcentaje) ? floor($resultado->porcentaje * 10) / 10 : null}}
                        </td>
                    </tr>
                    @if (count($item->competencia->criterios) > 0)
                        <tr style="background:#084063; color:white;">
                            <td colspan="2" style="background:#084063; color:white; text-align:center;">Item
                                Criterio Interno</td>
                            <td style="background:#084063; color:white; text-align:center;">Nota</td>
                            <td style="background:#084063; color:white; text-align:center;">Porcentaje</td>
                        </tr>
                        @foreach ($item->competencia->criterios as $criterio)
                            <tr>
                                @php
                                    $resultadocriterio = $evaluacion->criterios
                                        ->where('criterio_id', $criterio->id)
                                        ->first();
                                @endphp
                                <td colspan="2" style="background:#084063; color:white;">
                                    -
                                    {{ $criterio->criterio }}
                                    @if ($resultadocriterio->comentarios)
                                        <hr>
                                        <p><span style="font-weight:bold">Comentarios:</span>
                                            {{ $resultadocriterio->comentarios }}</p>
                                    @endif
                                </td>
                                <td style="background:#084063; color:white; text-align:center;">
                                {{ isset($resultadocriterio->nota) ? floor($resultadocriterio->nota * 10) / 10 : null }}</td>
                                <td style="background:#084063; color:white; text-align:center;">
                                    {{ isset($resultadocriterio->nota) ? floor((($resultadocriterio->nota / 4) * 100) * 10) / 10 : null }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    @endforeach
    <h4>Resultados de la Evaluación Practica</h4>
    <table class="tg">
        <thead>
            <tr>
                <th style="background: #ddebff; text-align:center;">Nota</th>
                <th style="background: #ddebff; text-align:center;">Porcentaje de Aprobación</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center;">{{ floor($evaluacion->nota_practica * 10) / 10  }}</td>
                <td
                    style="{{ $evaluacion->porcentaje_practica < 75 || $evaluacion->aprobacion->estado == 0 ? 'background:#fa896b; color:white; text-align:center; text-align:center;' : 'background:#13deb9; color:#343a40; text-align:center;' }}">
                   {{ floor($evaluacion->porcentaje_practica * 10) / 10  }}%</td>
            </tr>
        </tbody>
    </table>
    <p style="font-size: 14px;">Leyenda:
        <hr><span style="font-size: 14px; background:#fa896b; color:white; padding:4px; border-radius: 10px;">NO
            ACREDITADO</span> <span
            style="font-size: 14px; background:#13deb9; color:#343a40; padding:4px; border-radius: 10px;">ACREDITADO</span>
    </p>
    <hr>
    <h4>Comentarios Evaluación Practica</h4>
    <p style="font-size: 14px;">{{ $evaluacion->comentarios }}</p>
@else
    <p style="font-size: 14px;">Aun no se han registrado resultados</p>
@endif
<h3>Información Evaluación Teórica</h3>
@if ($evaluacion->teorica)
    <table class="tg">
        <thead>
            <tr>
                <th style="background: #ddebff">#</th>
                <th style="background: #ddebff">Competencia</th>
                <th style="background: #ddebff">Pregunta</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1; @endphp
            @foreach ($evaluacion->teorica->items as $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->competencia->nombre }}
                        @if ($item->comentario)
                            <hr>
                            <p><span style="font-weight:bold">Comentarios:</span>
                                {{ $item->comentario }}</p>
                        @endif
                    </td>
                    <td>{{ $item->pregunta }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>
    <h4>Resultados de la Evaluación Practica</h4>
    <table class="tg">
        <thead>
            <tr>
                <th style="background: #ddebff">Nota</th>
                <th style="background: #ddebff">Porcentaje de Aprobación</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center;">{{ floor($evaluacion->teorica->nota * 10) / 10  }}</td>
                <td style="text-align:center;">{{ floor($evaluacion->teorica->porcentaje_teorica * 10) / 10  }}%</td>
            </tr>
        </tbody>
    </table>
@else
    <p style="font-size: 14px;">Aun no se ha registrado una evaluacion teórica</p>
@endif
<h3>Resultado Final</h3>
@if ($evaluacion->teorica && $evaluacion->resultado->isNotEmpty())
    <table class="tg">
        <thead>
            <tr>
                <th style="background: #ddebff">Nota de Evaluación Practica</th>
                <th style="background: #ddebff">Porcentaje de Evaluación Practica</th>
                <th style="background: #ddebff">Nota de Evaluación Teórica</th>
                <th style="background: #ddebff">Porcentaje de Evaluación Teórica</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center;">{{ floor($evaluacion->nota_practica * 10) / 10  }}</td>
                <td style="text-align:center;">{{ floor($evaluacion->porcentaje_practica * 10) / 10  }}%</td>
                <td style="text-align:center;">{{ floor($evaluacion->teorica->nota * 10) / 10  }}</td>
                <td style="text-align:center;">{{ floor($evaluacion->teorica->porcentaje_teorica * 10) / 10  }}%</td>
            </tr>
            <tr>
                <td colspan="2">
                    La evaluación practica representa un 80% del total de la evaluación.
                </td>
                <td colspan="2">
                    La evaluación teórica representa un 20% del total de la evaluación.
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table class="tg">
        <thead>
            <tr>
                <th style="background: #ddebff">Nota Final</th>
                <th colspan="2" style="background: #ddebff">Porcentaje de Aprobación</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td
                    style="{{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 || $evaluacion->aprobacion->estado == 0 ? 'background:#fa896b; color:white; text-align:center;' : 'background:#13deb9; color:#343a40; text-align:center;' }}">
                    {{ floor(($evaluacion->nota_total + $evaluacion->teorica->nota_total) * 10) / 10  }}
                </td>
                <td
                    style="{{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 || $evaluacion->aprobacion->estado == 0 ? 'background:#fa896b; color:white; text-align:center;' : 'background:#13deb9; color:#343a40; text-align:center;' }}">
                    {{ floor(($evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total) * 10) / 10  }}%</td>
                <td
                    style="{{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 || $evaluacion->aprobacion->estado == 0 ? 'background:#fa896b; color:white; text-align:center;' : 'background:#13deb9; color:#343a40; text-align:center;' }}">
                    {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 || $evaluacion->aprobacion->estado == 0 ? 'TRABAJADOR NO ACREDITADO' : 'TRABAJADOR ACREDITADO' }}
                </td>
            </tr>
        </tbody>
    </table>
@else
    <p style="font-size: 14px;">Aun no se han registrado todas las evaluaciones necesarias</p>
@endif
<h3>Ver Informe Online</h3>
<img src="{{ $qr }}" alt="Código QR">
