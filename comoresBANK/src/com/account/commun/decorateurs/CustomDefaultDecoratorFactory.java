package com.account.commun.decorateurs;

import javax.servlet.jsp.PageContext;

import org.apache.commons.lang.StringUtils;
import org.displaytag.decorator.DecoratorFactory;
import org.displaytag.decorator.DefaultDecoratorFactory;
import org.displaytag.decorator.DisplaytagColumnDecorator;
import org.displaytag.decorator.TableDecorator;
import org.displaytag.exception.DecoratorInstantiationException;
import org.displaytag.util.ReflectHelper;

public class CustomDefaultDecoratorFactory implements DecoratorFactory{
	/**
     * <p>
     * If the user has specified a decorator, then this method takes care of creating the decorator (and checking to
     * make sure it is a subclass of the TableDecorator object). If there are any problems loading the decorator then
     * this will throw a DecoratorInstantiationException which will get propagated up to the page.
     * </p>
     * <p>
     * Two different methods for loading a decorator are handled by this factory:
     * </p>
     * <ul>
     * <li>First of all, an object with key <code>decoratorName</code> is searched in the page/request/session/scope</li>
     * <li>If not found, assume <code>decoratorName</code> is the class name of the decorator and load it using
     * reflection</li>
     * </ul>
     * @param decoratorName String full decorator class name
     * @return instance of TableDecorator
     * @throws DecoratorInstantiationException if unable to load specified TableDecorator
     */
    public TableDecorator loadTableDecorator(PageContext pageContext, String decoratorName)
        throws DecoratorInstantiationException
    {
        if (StringUtils.isBlank(decoratorName))
        {
            return null;
        }

        // first check: is decoratorName an object in page/request/session/application scope?
        Object decorator = pageContext.findAttribute(decoratorName);

        // second check: if a decorator was not found assume decoratorName is the class name and load it using
        // reflection
        if (decorator == null)
        {
            try
            {
                decorator = ReflectHelper.classForName(decoratorName).newInstance();
            }
            catch (ClassNotFoundException e)
            {
                throw new DecoratorInstantiationException(CustomDefaultDecoratorFactory.class, decoratorName, e);
            }
            catch (InstantiationException e)
            {
                throw new DecoratorInstantiationException(CustomDefaultDecoratorFactory.class, decoratorName, e);
            }
            catch (IllegalAccessException e)
            {
                throw new DecoratorInstantiationException(CustomDefaultDecoratorFactory.class, decoratorName, e);
            }
        }

        if (decorator instanceof TableDecorator)
        {
            return (TableDecorator) decorator;
        }
        else
        {
            throw new DecoratorInstantiationException(
                CustomDefaultDecoratorFactory.class,
                decoratorName,
                new ClassCastException(decorator.getClass().getName()));
        }

    }

    /**
     * <p>
     * If the user has specified a column decorator, then this method takes care of creating the decorator (and checking
     * to make sure it is a subclass of the DisplaytagColumnDecorator object). If there are any problems loading the
     * decorator then this will throw a DecoratorInstantiationException which will get propagated up to the page.
     * </p>
     * <p>
     * Two different methods for loading a decorator are handled by this factory:
     * </p>
     * <ul>
     * <li>First of all, an object with key <code>decoratorName</code> is searched in the page/request/session/scope</li>
     * <li>If not found, assume <code>decoratorName</code> is the class name of the decorator and load it using
     * reflection</li>
     * </ul>
     * @param decoratorName String full decorator class name
     * @return instance of DisplaytagColumnDecorator
     * @throws DecoratorInstantiationException if unable to load ColumnDecorator
     */
    public DisplaytagColumnDecorator loadColumnDecorator(PageContext pageContext, String decoratorName)
        throws DecoratorInstantiationException
    {
        if (StringUtils.isBlank(decoratorName))
        {
            return null;
        }

        // first check: is decoratorName an object in page/request/session/application scope?
        Object decorator = pageContext.findAttribute(decoratorName);

        // second check: if a decorator was not found assume decoratorName is the class name and load it using
        // reflection
        if (decorator == null)
        {
            try
            {
                decorator = ReflectHelper.classForName(decoratorName).newInstance();
            }
            catch (ClassNotFoundException e)
            {
                throw new DecoratorInstantiationException(CustomDefaultDecoratorFactory.class, decoratorName, e);
            }
            catch (InstantiationException e)
            {
                throw new DecoratorInstantiationException(CustomDefaultDecoratorFactory.class, decoratorName, e);
            }
            catch (IllegalAccessException e)
            {
                throw new DecoratorInstantiationException(CustomDefaultDecoratorFactory.class, decoratorName, e);
            }
        }

        if (decorator instanceof DisplaytagColumnDecorator)
        {
            return (DisplaytagColumnDecorator) decorator;
        }
        else
        {
            throw new DecoratorInstantiationException(
                CustomDefaultDecoratorFactory.class,
                decoratorName,
                new ClassCastException(decorator.getClass().getName()));
        }
    }
}
