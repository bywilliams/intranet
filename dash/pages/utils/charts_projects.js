        // CHART 1
         var xValues1 = ["Concluido", "falta"];
         var yValues1 = [<?=$percent1?>, (100 - <?=$percent1?>)];
         var barColors1 = [
             "#D1512D",
             "#ccc"
         ];
        
         // CHART 2
         var xValues2 = ["Concluido", "falta"];
         var yValues2 = [<?=$percent2?>, (100 - <?=$percent2?>)];
         var barColors2 = [
             "#319DA0",
             "#ccc"
         ];
        
          // CHART 3
          var xValues3 = ["Concluido", "falta"];
         var yValues3 = [<?=$percent3?>, (100 - <?=$percent3?>)];
         var barColors3 = [
             "#781C68",
             "#ccc"
         ];
        
        
         new Chart("myChart1", {
             type: "pie",
             data: {
                 labels: xValues1,
                 datasets: [{
                     backgroundColor: barColors1,
                     data: yValues1
                 }]
             },
             options: {
                 title: {
                     display: true,
                     text: "% do Projeto <?=$title1?>"
                 }
             }
         });
        
         new Chart("myChart2", {
             type: "pie",
             data: {
                 labels: xValues2,
                 datasets: [{
                     backgroundColor: barColors2,
                     data: yValues2
                 }]
             },
             options: {
                 title: {
                     display: true,
                     text: "% do Projeto <?=$title2?>"
                 }
             }
         });
        
         new Chart("myChart3", {
             type: "pie",
             data: {
                 labels: xValues3,
                 datasets: [{
                     backgroundColor: barColors3,
                     data: yValues3
                 }]
             },
             options: {
                 title: {
                     display: true,
                     text: "% do Projeto <?=$title3?>"
                 }
             }
         });