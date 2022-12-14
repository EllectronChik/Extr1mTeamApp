$(function() {

   $(".reg input").focus(function() {
      $(this).parent(".input").each(function() {
         $(".spin", this).css({
            "width": "400%"
         })
      })
   })
   $(".log input").focus(function() {
      $(this).parent(".input").each(function() {
         $(".spin", this).css({
            "width": "100%"
         })
      })
   })
   $(".add_mate input").focus(function() {
      $(this).parent(".input").each(function() {
         $(".spin", this).css({
            "width": "250%"
         })
      })
   })

   $(".input input").focus(function() {

      $(this).parent(".input").each(function() {
         $("label", this).css({
            "line-height": "1.8vh",
            "font-size": "1.8vh",
            "font-weight": "100",
            "top": "0vh"
         })
      });
   }).blur(function() {
      $(".spin").css({
         "width": "0px"
      })
      if ($(this).val() == "") {
         $(this).parent(".input").each(function() {
            $("label", this).css({
               "line-height": "6vh",
               "font-size": "2.4vh",
               "font-weight": "300",
               "top": "1vh"
            })
         });

      }
   });
   });



$(window).resize(function() {
   var h_logo = $(".h_logo").width();
   var h_name = $(".h_name").width();
   var h_block_1 = $(".h_block_1").width();
   var h_block_2 = $(".h_block_2").width();
   var header = $("header").width();
   if (h_block_1 + h_block_2 >= header) {
      $(".h_block_1").css({
         "width": '${h_block_1} - 20'
      })
   }
   if (h_logo + h_name + 22 >= h_block_1) {
      $(".h_logo").css({
         "height": "10vh"
      })
   } else {
      $(".h_logo").css("height", "15vh")
   }
})


document.addEventListener('DOMContentLoaded', () => {

   const getSort = ({ target }) => {
       const order = (target.dataset.order = -(target.dataset.order || -1));
       const index = [...target.parentNode.cells].indexOf(target);
       const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
       const comparator = (index, order) => (a, b) => order * collator.compare(
           a.children[index].innerHTML,
           b.children[index].innerHTML
       );
       
       for(const tBody of target.closest('table').tBodies)
           tBody.append(...[...tBody.rows].sort(comparator(index, order)));

       for(const cell of target.parentNode.cells)
           cell.classList.toggle('sorted', cell === target);
   };
   
   document.querySelectorAll('.table_sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
   
});

