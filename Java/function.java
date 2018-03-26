/*---------------------------------- java 输入 定义数组 接收用户输入   ------------------------------------*/
System.out.print("");//普通输出
System.out.println("");//换行输出

import java.util.Scanner;
public class hello {
    public static void main(String[] args){

        System.out.println("hello world");
        Scanner input = new Scanner(System.in); //实例化类
        System.out.println("请先输入:"); 

        if (input.hasNext()){//判断是否存在输入
            String strs = input.next(); //接收输入值
            System.out.println("输入的内容为:"+strs);
        }
    }

}

/*---------------------------------- java 数组   ------------------------------------*/

        int arrNmae[] = {1,2,3,4}; //定义数组及赋值
        System.out.println(arrNmae[1]); //取数组值

        // 定义一个长度为5的字符串数组
		String[] subjects = new String[5] ;//定义数组及长度
		String  subjects[] = new String[5] ;

        //二维数组
        int[][] num = {{1,1,1},{2,2,2}};//定义并赋值
        int[][] num = new int[3][];//定义数组及长度 没赋值  二维数组第一个长度必须定义
/*---------------------------------- java for循环   ------------------------------------*/
		
		for(int i= 0;i<hobbys.length;i++){
		  System.out.println(hobbys[i]);
		}
		int i = 0;//内容可省略 但是 ; 不可省略 i++也可省略 但必须自循环内添加条件否则死循环
		for(;i<hobbys.length;i++){
		  System.out.println(hobbys[i]);
		}

	  // 使用foreach遍历输出数组中的元素
	  // for (int|String name : 要遍历的对象 ) {
	  }
		for ( int score : scores) {
			System.out.println(score);
		}

/*---------------------------------- java for循环   ------------------------------------*/
/*1、 排序
import java.util.Arrays;

语法：  Arrays.sort(数组名);

升序: 可以使用 sort( ) 方法实现对数组的排序，只要将数组名放在 sort( ) 方法的括号中，就可以完成对该数组的排序（按升序排列），如：

降序: 使用for循环 --i 一次获取升序之后的数组


2、 将数组转换为字符串

语法：  Arrays.toString(数组名);

可以使用 toString( ) 方法将一个数组转换成字符串，该方法按顺序把多个数组元素连接在一起，多个元素之间使用逗号和空格隔开，如：


*/

/*---------------------------------- java 定义方法   ------------------------------------*/
/*
访问修饰符  返回值类型  方法名(参数列表)
	public   (无返回值就用void) void 		funname(参数){
		方法体
	}

1、访问修饰符：方法允许被访问的权限范围， 可以是 public、protected、private 甚至可以省略 ，其中 public 表示该方法可以被其他任何代码调用，其他几种修饰符的使用在后面章节中会详细讲解滴

2、返回值类型：方法返回值的类型，如果方法不返回任何值，则返回值类型指定为 void;如果方法具有返回值，则需要指定返回值的类型，并且在方法体中使用 return 语句返回值

3、方法名：定义的方法的名字，必须使用合法的标识符

4、参数列表：传递给方法的参数列表，参数可以有多个，多个参数间以逗号隔开，每个参数由参数类型和参数名组成，以空格隔开 
*/
public class HelloWorld {
    
    public static void main(String[] args){
        //在 main 方法中调用 print 方法
        HelloWorld test=new HelloWorld();
        test.print();
        int arr[] = {1,2,3};
        int params = test.funOne();
        int[] paramsTwo = test.funTwo(1,arr,'111');
    }

    //定义了一个方法名为 print 的方法 无参数
    public void print() {
		System.out.println("Hello World");
	}
    public int funOne()
    {
    	int a = 1;
    	return a;
    }
    //返回一个数组
     public int[] funTwo(int num,int arr[],String str)
    {
       
        return arr1;
    }
}
